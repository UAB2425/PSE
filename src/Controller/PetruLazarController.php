<?php

namespace App\Controller;

use App\Entity\PetruLazar\Account;
use App\Entity\PetruLazar\Glyph;
use App\Entity\PetruLazar\Phrase;
use App\Entity\PetruLazar\PhraseElement;
use App\Entity\PetruLazar\Word;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Attribute\Route;

class PetruLazarController extends AbstractController
{
    public function objectsToArrays(array $arr): array
    {
        $res = [];
        foreach ($arr as $elem) {
            $res[] = $elem->getArray();
        }
        return $res;
    }

    #[Route(path: "/petrulazar", name: "petrulazar_hero")]
    public function hero(): Response
    {
        return $this->render("petrulazar/hero.html.twig");
    }

    #[Route(path: "/petrulazar/login", name: "petrulazar_login")]
    public function login(Request $req, EntityManagerInterface $em): Response
    {
        $sess = $req->getSession();
        if ($sess->get("loggedIn") == true)
            $sess->set("loggedIn", false);

        $twig_params = [
            "login_error" => "",
            "username" => "",
            "user_error" => false,
            "password_error" => false,
        ];

        if ($req->isMethod('POST')) {
            // get username and password from user
            $username = $req->request->get("username");
            $password = $req->request->get("password");
            $twig_params["username"] = $username;

            // get username and password from db
            $accounts = $em->getRepository(Account::class)->findBy([
                "username" => $username
            ]);

            // check them against each other
            if (count($accounts) != 1) {
                $twig_params["login_error"] = "Unknown username";
                $twig_params["user_error"] = true;
            } else if (!password_verify($password, $accounts[0]->getPassword())) {
                $twig_params["login_error"] = "Wrong password";
                $twig_params["password_error"] = true;
            } else {
                // login if details are correct
                // session stuff...
                $req->getSession()->set("loggedIn", true);

                return $this->redirectToRoute('petrulazar_dictionary');
            }

            return $this->render("petrulazar/login.html.twig", $twig_params);
        }

        return $this->render("petrulazar/login.html.twig", $twig_params);
    }

    #[Route(path: "/petrulazar/dictionary", name: "petrulazar_dictionary")]
    public function dictionary(Request $req, EntityManagerInterface $em): Response
    {
        $isLoggedIn = $req->getSession()->get("loggedIn");
        // if ($isLoggedIn && rand(1, 2) == 1)
        //     $isLoggedIn = false;
        $conn = $em->getConnection();

        if ($req->isMethod("POST")) {
            $payload = $req->getPayload();
            $action = $payload->get("action");
            $query = $payload->get("query");

            $words = [];
            $glyphs = [];
            $phrase_elements = [];

            // parse search query
            $searchedWords = array_filter(explode(' ', $query), function ($v) {
                return $v != "";
            });

            if ($action == "word_edit") {
                // edit protection
                if (!$isLoggedIn)
                    throw new UnauthorizedHttpException('Not logged in');

                // parse arguments
                $searchQueryOption = $payload->get("searchQueryOption");
                $word_id = $payload->get("word_id");
                $word_glyphs = $payload->get("word_glyphs");
                $word_translation = $payload->get("word_translation");
                $word_confirmed = $payload->get("word_confirmed");

                // fall back to response with search results
                if ($searchQueryOption == "ancient") {
                    $action = "search_ancient";
                } else if ($searchQueryOption == "english") {
                    $action = "search_english";
                } else {
                    throw new BadRequestHttpException('Invalid searchQueryOption');
                }

                $word = $em->getRepository(Word::class)->find($word_id);
                if (!$word)
                    throw new BadRequestHttpException('Invalid word id');

                if (strlen($word_glyphs) == 0) {
                    // trying to delete
                    $phraseElements = $em->getRepository(PhraseElement::class)->findBy([
                        "word_id" => $word_id
                    ]);
                    if (count($phraseElements) != 0)
                        throw new BadRequestHttpException('Word is not unused');

                    $em->remove($word);
                    $em->flush();
                } else {
                    // trying to edit

                    // update entity
                    $other_words = $em->getRepository(Word::class)->findBy([
                        "glyphs" => $word_glyphs
                    ]);
                    foreach ($other_words as $other_word)
                        if ($other_word->getId() != $word_id)
                            throw new BadRequestHttpException('Duplicate word');

                    $word->setGlyphs($word_glyphs);
                    $word->setTranslation($word_translation);
                    $word->setConfirmed($word_confirmed);

                    $em->flush();
                }
            } else if ($action == 'new_entry') {
                // edit protection
                if (!$isLoggedIn)
                    throw new UnauthorizedHttpException('Not logged in');

                // fall back to response with search results
                $action = "search_ancient";

                // check if phrase already exists
                $i = 0;
                $queryConditions = [];
                if (count($searchedWords) == 0)
                    throw new BadRequestHttpException("Cannot add empty phrase");
                foreach ($searchedWords as $searchedWord) {
                    $possiblePhrases = $conn->executeQuery(
                        "select phrase_id from phrase_element inner join word on phrase_element.word_id = word.id where word.glyphs = ? and phrase_element.position_in_phrase = ?",
                        [
                            $searchedWord,
                            ++$i
                        ]
                    )->fetchAllAssociative();
                    $possiblePhrases = array_column($possiblePhrases, 'phrase_id');

                    if (count($possiblePhrases) > 0) {
                        $queryConditions[] = "phrase_id in (" . implode(",", $possiblePhrases) . ")";
                    } else {
                        $queryConditions = [];
                        break;
                    }
                }
                if (count($queryConditions) > 0) {
                    $existing_phrases = $conn->executeQuery(
                        "select phrase_id from phrase_element inner join word on phrase_element.word_id = word.id where " .
                        implode(" and ", $queryConditions) .
                        " group by phrase_id
                        having count(*) = $i",
                    )->fetchAllAssociative();

                    if (count($existing_phrases) != 0)
                        throw new BadRequestHttpException('Phrase already exist');
                }

                // update database
                // add the phrase
                $phrase = new Phrase();
                $em->persist($phrase);
                $em->flush();

                // add each word in database and/or phrase
                $i = 0;
                foreach ($searchedWords as $searchedWord) {
                    // check if word exists
                    $word = $em->getRepository(Word::class)->findBy([
                        "glyphs" => $searchedWord
                    ]);
                    if (count($word) > 1)
                        throw new HttpException(500, 'Duplicate words in database');
                    else if (count($word) == 0) {
                        $word = new Word();
                        $word->setGlyphs($searchedWord);
                        $word->setTranslation("");
                        $word->setConfirmed(false);
                        $word->setPronunciation("");

                        $em->persist($word);
                        $em->flush();
                    } else $word = $word[0];

                    $phrase_element = new PhraseElement();
                    $phrase_element->setPhraseId($phrase->getId());
                    $phrase_element->setWordId($word->getId());
                    $phrase_element->setPositionInPhrase(++$i);
                    $em->persist($phrase_element);
                }
                $em->flush();
            } else if ($action == 'delete_phrase') {
                // edit protection
                if (!$isLoggedIn)
                    throw new UnauthorizedHttpException('Not logged in');

                // parse arguments
                $searchQueryOption = $payload->get("searchQueryOption");
                $phrase_id = $payload->get("phraseId");

                // fall back to response with search results
                if ($searchQueryOption == "ancient") {
                    $action = "search_ancient";
                } else if ($searchQueryOption == "english") {
                    $action = "search_english";
                } else {
                    throw new BadRequestHttpException('Invalid searchQueryOption');
                }

                $phrase = $em->getRepository(Phrase::class)->find($phrase_id);
                $phraseElements = $em->getRepository(PhraseElement::class)->findBy([
                    "phrase_id" => $phrase_id
                ]);

                if (count($phraseElements) == 0 || !$phrase)
                    throw new BadRequestHttpException('Invalid phrase ID');

                foreach ($phraseElements as $phraseElement) {
                    $em->remove($phraseElement);
                }
                $em->remove($phrase);
                $em->flush();
            }

            if (count($searchedWords) == 0) {
                // no words
                // display all
                $glyphs = $conn->executeQuery(
                    "select * from glyph"
                )->fetchAllAssociative();
                $words = $conn->executeQuery(
                    "select * from word"
                )->fetchAllAssociative();
                $phrase_elements = $conn->executeQuery(
                    "select * from phrase_element inner join word on phrase_element.word_id=word.id
                    order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc"
                )->fetchAllAssociative();
            } else if ($action == "search_ancient") {
                // user is searching ancient

                if (count($searchedWords) == 1 && strlen($searchedWords[0]) == 1) {
                    // glyph search
                    // glyph + words containing glyph + phrase containing glyph
                    $glyphs = $conn->executeQuery(
                        "select * from glyph
                        where glyph.ancient_glyph=:searchedGlyph",
                        ["searchedGlyph" => $searchedWords[0]]
                    )->fetchAllAssociative();
                    $words = $conn->executeQuery(
                        "select * from word
                        where word.glyphs like :searchedGlyph",
                        ["searchedGlyph" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                    $phrase_elements = $conn->executeQuery(
                        "select * from phrase_element inner join word on phrase_element.word_id=word.id where phrase_element.phrase_id in
                        (select phrase_id from phrase_element inner join word on phrase_element.word_id=word.id where word.glyphs like :searchedGlyph)
                        order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc",
                        ["searchedGlyph" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                } else if (count($searchedWords) == 1) {
                    // word search
                    // glyphs in words + words containing glyphs - phrases containing glyphs
                    $words = $conn->executeQuery(
                        "select * from word
                        where word.glyphs like :searchedGlyphs",
                        ["searchedGlyphs" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                    $glyphs = [];
                    foreach ($words as $word) {
                        foreach (str_split($word['glyphs']) as $glyph) {
                            $glyphs[$glyph] = " ";
                        }
                    }
                    $glyphs = array_keys($glyphs);
                    $glyphs = $em->getRepository(Glyph::class)->findBy([
                        "ancient_glyph" => $glyphs
                    ]);
                    $glyphs = $this->objectsToArrays($glyphs);
                    $phrase_elements = $conn->executeQuery(
                        "select * from phrase_element inner join word on phrase_element.word_id=word.id where phrase_element.phrase_id in
                        (select phrase_id from phrase_element inner join word on phrase_element.word_id=word.id where word.glyphs like :searchedGlyphs)
                        order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc",
                        ["searchedGlyphs" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                } else {
                    // phrase search
                    // glyphs in words + words in phrase + phrase
                    $i = 0;
                    $wordQueryConditions = [];
                    $wordQueryReplacementItems = [];
                    $phraseQueryConditions = [];

                    foreach ($searchedWords as $searchedWord) {
                        $possiblePhrases = $conn->executeQuery(
                            "select phrase_id from phrase_element inner join word on phrase_element.word_id = word.id where word.glyphs like ? and phrase_element.position_in_phrase = ?",
                            [
                                '%' . $searchedWord . '%',
                                ++$i
                            ]
                        )->fetchAllAssociative();
                        $possiblePhrases = array_column($possiblePhrases, "phrase_id");

                        if (count($possiblePhrases) > 0) {
                            $phraseQueryConditions[] = "phrase_id in (" . implode(",", $possiblePhrases) . ")";
                        } else {
                            $phraseQueryConditions = [];
                            break;
                        }
                    }
                    foreach ($searchedWords as $searchedWord) {
                        $wordQueryConditions[] = "word.glyphs like ?";
                        $wordQueryReplacementItems[] = '%' . $searchedWord . '%';
                    }

                    $words = $conn->executeQuery(
                        "select * from word where " .
                        implode(" or ", $wordQueryConditions),
                        $wordQueryReplacementItems
                    )->fetchAllAssociative();

                    $glyphs = [];
                    foreach ($words as $word) {
                        foreach (str_split($word['glyphs']) as $glyph) {
                            $glyphs[$glyph] = " ";
                        }
                    }
                    $glyphs = array_keys($glyphs);
                    $glyphs = $em->getRepository(Glyph::class)->findBy([
                        "ancient_glyph" => $glyphs
                    ]);
                    $glyphs = $this->objectsToArrays($glyphs);

                    if (count($phraseQueryConditions) > 0) {
                        $phrase_elements = $conn->executeQuery(
                            "select * from phrase_element inner join word on phrase_element.word_id = word.id where " .
                            implode(" and ", $phraseQueryConditions) .
                            " order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc",
                        )->fetchAllAssociative();
                    } else {
                        $phrase_elements = [];
                    }
                }
            } else if ($action == "search_english") {
                // user is searching english

                if (count($searchedWords) == 1) {
                    // single word search (or single glyph)
                    $words = $conn->executeQuery(
                        "select * from word
                        where word.translation like :searchedKeyword",
                        ["searchedKeyword" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                    $glyphs = $conn->executeQuery(
                        "select * from glyph
                        where glyph.meaning like :searchedKeyword",
                        ["searchedKeyword" => '%' . $searchedWords[0] . '%']
                    )->fetchAllAssociative();
                    if (count($words) > 0) {
                        $phrase_elements = $conn->executeQuery(
                            "select * from phrase_element inner join word on phrase_element.word_id=word.id where phrase_element.phrase_id in
                            (select phrase_id from phrase_element where word_id in (" . implode(",", array_column($words, "id")) . "))
                            order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc"
                        )->fetchAllAssociative();
                    }
                } else {
                    // multiple word search
                    $i = 0;
                    $glyphQueryConditions = [];
                    $glyphQueryReplacementItems = [];
                    $wordQueryConditions = [];
                    $wordQueryReplacementItems = [];
                    $phraseQueryConditions = [];

                    foreach ($searchedWords as $searchedWord) {
                        $possiblePhrases = $conn->executeQuery(
                            "select phrase_id from phrase_element inner join word on phrase_element.word_id = word.id where word.translation like ? and phrase_element.position_in_phrase = ?",
                            [
                                '%' . $searchedWord . '%',
                                ++$i
                            ]
                        )->fetchAllAssociative();
                        $possiblePhrases = array_column($possiblePhrases, 'phrase_id');

                        if (count($possiblePhrases) > 0) {
                            $phraseQueryConditions[] = "phrase_id in (" . implode(",", $possiblePhrases) . ")";
                        } else {
                            $phraseQueryConditions = [];
                            break;
                        }
                    }
                    foreach ($searchedWords as $searchedWord) {
                        $glyphQueryConditions[] = "glyph.meaning like ?";
                        $glyphQueryReplacementItems[] = '%' . $searchedWord . '%';

                        $wordQueryConditions[] = "word.translation like ?";
                        $wordQueryReplacementItems[] = '%' . $searchedWord . '%';
                    }

                    $glyphs = $conn->executeQuery(
                        "select * from glyph where " .
                        implode(" or ", $glyphQueryConditions),
                        $glyphQueryReplacementItems
                    )->fetchAllAssociative();
                    $words = $conn->executeQuery(
                        "select * from word where " .
                        implode(" or ", $wordQueryConditions),
                        $wordQueryReplacementItems
                    )->fetchAllAssociative();

                    if (count($phraseQueryConditions) > 0) {
                        $phrase_elements = $conn->executeQuery(
                            "select * from phrase_element inner join word on phrase_element.word_id=word.id where " .
                            implode(" and ", $phraseQueryConditions),
                        )->fetchAllAssociative();
                    } else {
                        $phrase_elements = [];
                    }
                }
            } else
                throw new BadRequestHttpException('Invalid action');

            $phrases = [];

            foreach ($phrase_elements as $phrase_element) {
                $phrase_id = $phrase_element['phrase_id'];
                $phrases[$phrase_id]['id'] = $phrase_element['phrase_id'];
                $phrases[$phrase_id]['words'][$phrase_element['position_in_phrase']] = $phrase_element;
            }

            $twig_params = [
                "glyphs" => $glyphs,
                "words" => $words,
                "phrases" => $phrases,
                "loggedIn" => $isLoggedIn
            ];

            return new JsonResponse([
                "glyphs" => $this->renderBlockView("petrulazar/dictionary.html.twig", "glyphs_block", $twig_params),
                "words" => $this->renderBlockView("petrulazar/dictionary.html.twig", "words_block", $twig_params),
                "phrases" => $this->renderBlockView("petrulazar/dictionary.html.twig", "phrases_block", $twig_params)
            ]);
        }

        $glyphs = $conn->executeQuery(
            "select * from glyph"
        )->fetchAllAssociative();
        $words = $conn->executeQuery(
            "select * from word"
        )->fetchAllAssociative();
        $phrase_elements = $conn->executeQuery(
            "select * from phrase_element inner join word on phrase_element.word_id=word.id
            order by phrase_element.phrase_id asc, phrase_element.position_in_phrase asc"
        )->fetchAllAssociative();

        $phrases = [];

        foreach ($phrase_elements as $phrase_element) {
            $phrase_id = $phrase_element['phrase_id'];
            $phrases[$phrase_id]['id'] = $phrase_element['phrase_id'];
            $phrases[$phrase_id]['words'][$phrase_element['position_in_phrase']] = $phrase_element;
        }

        $twig_params = [
            "glyphs" => $glyphs,
            "words" => $words,
            "phrases" => $phrases,
            "loggedIn" => $isLoggedIn
        ];

        return $this->render("petrulazar/dictionary.html.twig", $twig_params);
    }
}
