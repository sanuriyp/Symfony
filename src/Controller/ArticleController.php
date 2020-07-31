<?php
   namespace App\Controller;
  
   use App\Entity\Article; //when creating objects in article class

   use Symfony\Component\HttpFoundation\Response; // response
   use Symfony\Component\HttpFoundation\Request;  //to request
   use Symfony\Component\Routing\Annotation\Route;
   use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method; //to give acess to specific methodes (post/ get)
   use Symfony\Bundle\FrameworkBundle\Controller\Controller;

   use Symfony\Component\Form\Extension\Core\Type\TextType; //to access the form texttype
   use Symfony\Component\Form\Extension\Core\Type\TextareaType;//variable type is textArea
   use Symfony\Component\Form\Extension\Core\Type\SubmitType; //variable type submit type

   class ArticleController extends Controller{
       /**
        * @Route("/",name="article_list")
        *@Method({"GET"})
        */
       public function index(){
           //return new Response('<html><body>Hello</body></html>');
           // to renter the twig file
           //return $this->render('articles/index.html.twig');
          // return $this->render('articles/index.html.twig',array('name' => 'Sanuri'));
          //$articles=['Article 1','Article 2']; this is hardcode array

          //fetch the data from database
          $articles=$this->getDoctrine()->getRepository
          (Article::class)->findAll();
          return $this->render('articles/index.html.twig',array('articles' => $articles));
        }

        
       

        /**
         * @Route("/article/new",name="new_article")
         * @Method({"GET","POST"})
        */

        public function new(Request $request){
            $article =new Article();

            $form =$this->createFormBuilder($article)
            ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('body', TextareaType::class, array(
              'required' => false,
              'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
              'label' => 'Create',
              'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $article = $form->getData();       // get the data from form

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('article_list');  //it redirect to the route"/" and create new record
            }

              return $this->render('articles/new.html.twig',array(
                  'form'=>$form->createView()
              ));
        }

        /**
         * @Route("/article/edit/{id}",name="edit_article")
         * @Method({"GET","POST"})
        */

       public function edit(Request $request,$id){
          $article =new Article();
          $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

        $form =$this->createFormBuilder($article)
          ->add('title', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('body', TextareaType::class, array(
            'required' => false,
            'attr' => array('class' => 'form-control')
          ))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-primary mt-3')
          ))
          ->getForm();

          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid()) {
              //$article = $form->getData(); 

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->flush();

              return $this->redirectToRoute('article_list');  //it redirect to the route"/" and create new record
          }

            return $this->render('articles/edit.html.twig',array(
                'form'=>$form->createView()
            ));
      }
      


         //The id  work as placeholder
        /**
         * @Route("/article/{id}",name="article_show")
         */
        public function show($id){
            $article=$this->getDoctrine()->getRepository
            (Article::class)->find($id);

            return $this->render('articles/show.html.twig',array
          ('article' =>$article));
      }

        /**
         * @Route("/article/delete/{id}")
         * @Method({"DELETE"})
         */
        public function delete(Request $request, $id){
            $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
      
            //send the response
            $response = new Response();
            $response->send();

        }
          
    //    /**
    //     * @Route("/article/save")
    //     */
    //    public function save(){
    //        $entityManager =$this->getDoctrine()->getManager();

    //        $article =new Article;
    //        $article->setTitle('Article Two');
    //        $article->setBody('This is the body for article two');

    //        $entityManager->persist($article);// presist is doing saving the data
    //        $entityManager->flush();//To exicute we need 

    //        return new Response('Saved an article with the id of '.$article->getId());

    //    }

    
   }