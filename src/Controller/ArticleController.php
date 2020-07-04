<?php
    namespace App\Controller;

    // if you are using composer, just use this
    //include 'vendor/autoload.php';

    use App\Entity\Articles;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\Finder\Finder;
    use Gufy\PdfToHtml;


    class ArticleController extends AbstractController{

        /**
         * @Route(path="/", methods={"GET"})
         */
        public function index(){
            //get all folders
             $glob = glob("joachim-articles-html/*");
                //print_r($glob);
            foreach ($glob as $filename) {
                //for every folder, get html article
                $glob2 = glob("${filename}/*html");
                var_dump($filename);
                //for every html, get its content and translate html entities to push to db
                foreach ($glob2 as $html){
                   var_dump( "$html"."\n");
                    $htmlContent = file_get_contents($html);
                    $htmltag = preg_match( 'h1',$htmlContent);
                    var_dump($htmltag);

                  var_dump(htmlentities($htmlContent));

                }
            }
            //$finder = new Finder();
            //$finder->files()->in("joachim-articles-html");

            //foreach ($finder as $file) {
              //  $absoluteFilePath = $file->getRealPath();
               // $fileNameWithExtension = $file->getRelativePathname();

               //var_dump($absoluteFilePath,$fileNameWithExtension);
            //}

            $articles =['art1','art2','art3'];
            return $this->render('articles/index.html.twig', array('articles' =>$articles));
        }

        /**
         * @Route (path="/article/save", methods={"GET"})
         */
        public function save(){
            $entityManager = $this->getDoctrine()->getManager();
            $article = new Articles();
            $article->setTitle("first article");
            $article->setBody("body text");
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
    }