<?php
    namespace App\Controller;

    // if you are using composer, just use this


    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Gufy\PdfToHtml;


    class ArticleController extends AbstractController{





        /**
         * @Route(path="/", methods={"GET"})
         */
        public function index(){
            // initiate
            $pdf = new PdfToHtml\Pdf('public/assets/pdftest.pdf');
            $html = $pdf->html();
            $page = $pdf->html(3);
            $articles =['art1','art2'];
            return $this->render('articles/index.html.twig', array('articles' =>$page));
        }
    }