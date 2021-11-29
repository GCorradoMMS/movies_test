<?php
 namespace App\Controller;

 use App\Entity\Movie;
 use App\Repository\MovieRepository;
 use Doctrine\ORM\EntityManagerInterface;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use Symfony\Component\HttpFoundation\Request;
 use Symfony\Component\Routing\Annotation\Route;

 /**
  * Class MovieController
  * @package App\Controller
  * @Route("/api", name="movies_api")
  */
 class MovieController
 {
     
  /**
   * @Route("/", name="hello", methods={"GET"})
   */
  public function index()
  {
    return $this->response('hello');
  }

  /**
   * @param MovieRepository $movieRepository
   * @return JsonResponse
   * @Route("/movies", name="movies", methods={"GET"})
   */
  public function getMovies(MovieRepository $movieRepository){
   $data = $movieRepository->findAll();
   return $this->response($data);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param MovieRepository $movieRepository
   * @return JsonResponse
   * @throws \Exception
   * @Route("/movies", name="movies_add", methods={"POST"})
   */
  public function addMovie(Request $request, EntityManagerInterface $entityManager, MovieRepository $movieRepository){

   try{
    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('title') || !$request->request->get('category') || !$request->request->get('thumbnail')){
     throw new \Exception();
    }

    $movie = new Movie();
    $movie->setTitle($request->get('title'));
    $movie->setCategory($request->get('category'));
    $movie->setThumbnail($request->get('thumbnail'));
    $entityManager->persist($movie);
    $entityManager->flush();

    $data = [
     'status' => 200,
     'success' => "Movie added successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Invalid data!",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param MovieRepository $movieRepository
   * @param $id
   * @return JsonResponse
   * @Route("/movies/{id}", name="movies_get", methods={"GET"})
   */
  public function getMovie(MovieRepository $movieRepository, $id){
   $movie = $movieRepository->find($id);

   if (!$movie){
    $data = [
     'status' => 404,
     'errors' => "Movie not found",
    ];
    return $this->response($data, 404);
   }
   return $this->response($movie);
  }

  /**
   * @param Request $request
   * @param EntityManagerInterface $entityManager
   * @param MovieRepository $movieRepository
   * @param $id
   * @return JsonResponse
   * @Route("/movies/{id}", name="movies_put", methods={"PUT"})
   */
  public function updateMovie(Request $request, EntityManagerInterface $entityManager, MovieRepository $movieRepository, $id){

   try{
    $movie = $movieRepository->find($id);

    if (!$movie){
     $data = [
      'status' => 404,
      'errors' => "Movie not found",
     ];
     return $this->response($data, 404);
    }

    $request = $this->transformJsonBody($request);

    if (!$request || !$request->get('title') || !$request->request->get('category') || !$request->request->get('thumbnail')){
     throw new \Exception();
    }

    $movie->setTitle($request->get('title'));
    $movie->setCategory($request->get('category'));
    $movie->setThumbnail($request->get('thumbnail'));
    $entityManager->flush();

    $data = [
     'status' => 200,
     'errors' => "Movie updated successfully",
    ];
    return $this->response($data);

   }catch (\Exception $e){
    $data = [
     'status' => 422,
     'errors' => "Invalid data!",
    ];
    return $this->response($data, 422);
   }

  }


  /**
   * @param MovieRepository $movieRepository
   * @param $id
   * @return JsonResponse
   * @Route("/movies/{id}", name="movies_delete", methods={"DELETE"})
   */
  public function deleteMovie(EntityManagerInterface $entityManager, MovieRepository $movieRepository, $id){
   $movie = $movieRepository->find($id);

   if (!$movie){
    $data = [
     'status' => 404,
     'errors' => "Movie not found",
    ];
    return $this->response($data, 404);
   }

   $entityManager->remove($movie);
   $entityManager->flush();
   $data = [
    'status' => 200,
    'errors' => "Movie deleted successfully",
   ];
   return $this->response($data);
  }

  /**
   * Returns a JSON response
   *
   * @param array $data
   * @param $status
   * @param array $headers
   * @return JsonResponse
   */
  public function response($data, $status = 200, $headers = [])
  {
   return new JsonResponse($data, $status, $headers);
  }

  protected function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request)
  {
   $data = json_decode($request->getContent(), true);

   if ($data === null) {
    return $request;
   }

   $request->request->replace($data);

   return $request;
  }
 }