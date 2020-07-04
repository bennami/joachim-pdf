<?php
    namespace App\Controller;

    use App\Entity\Articles;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\DomCrawler\Crawler;



    class ArticleController extends AbstractController{

        /**
         * @Route(path="/", methods={"GET"})
         */
        public function index(){

            //get all folders that contain html articles
            $glob = glob("joachim-articles-html/*");
            foreach ($glob as $folder) {
                //for every folder, get html article
                $glob2 = glob("${folder}/*html");

                //for every html, get its content and translate html entities to push to db
                foreach ($glob2 as $html){
                    //get content of html file
                    $htmlContent = file_get_contents($html);
                    $htmlforDB = htmlentities($htmlContent);

                    //get title of article
                    $crawler2 = new Crawler($htmlContent);
                    $crawler2 = $crawler2->filter('head > title')->text();
                    var_dump($crawler2);



                    //save to db
                    //$this->save($crawler2,$htmlforDB);

                }
            }
            //get all articles
            $entityManager = $this->getDoctrine()->getManager();
            $product = $entityManager->getRepository('App:Articles');
            $articles= $product->findAll();

            //convert back to html tags before displaying
            foreach ($articles as $article){
                $body =[];
              array_push($body, html_entity_decode($article->getBody())) ;
            }
            return $this->render('articles/index.html.twig', array('articles' =>$articles, 'bodyText'=> $body));
        }

        /**
         * @Route (path="/article/save", methods={"GET"})
         */
        public function save($title,$html){
            $entityManager = $this->getDoctrine()->getManager();
            $article = new Articles();
            $article->setTitle($title);
            $article->setBody($html);
            $entityManager->persist($article);
            $entityManager->flush();

            return new Response('saves article with id of'.$article->getId());
        }

        /**
         * @Route (path="/about", methods={"GET"})
         */
        public function about(){
            return $this->render('about/index.html.twig');
        }

        /**
         * @Route (path="/article/id", methods={"GET"})
         */

    }