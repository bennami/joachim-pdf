<?php
    namespace App\Controller;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    class ArticleController extends AbstractController{
        /**
         * @Route(path="/", methods={"GET"})
         */
        public function index(){

            $articles =['art1','art2'];
            return $this->render('articles/index.html.twig', array('articles' =>$articles));
        }
    }