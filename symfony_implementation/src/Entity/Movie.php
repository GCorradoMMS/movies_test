<?php
 namespace App\Entity;
 use Doctrine\ORM\Mapping as ORM;
 use Symfony\Component\Validator\Constraints as Assert;
 /**
  * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
  * @ORM\Table(name="moviesymfony")
  * @ORM\HasLifecycleCallbacks()
  */
 class Movie implements \JsonSerializable {
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $movie_id;
  /**
   * @ORM\Column(type="string", length=100)
   *
   */
  private $title;
  /**
   * @ORM\Column(type="string", length=100)
   */
  private $category;
  /**
   * @ORM\Column(type="string", length=100)
   */
  private $thumbnail;
  /**
   * @ORM\Column(type="datetime")
   */
  private $date_created;
  /**
   * @ORM\Column(type="datetime")
   */
  private $date_updated;

  /**
   * @return mixed
   */
  public function getMovieId()
  {
   return $this->movie_id;
  }
  /**
   * @param mixed $movie_id
   */
  public function setMovieId($movie_id)
  {
   $this->movie_id = $movie_id;
  }
  /**
   * @return mixed
   */
  public function getTitle()
  {
   return $this->title;
  }
  /**
   * @param mixed $title
   */
  public function setTitle($title)
  {
   $this->name = $title;
  }
  /**
   * @return mixed
   */
  public function getCategory()
  {
   return $this->category;
  }
  /**
   * @param mixed $description
   */
  public function setCategory($category)
  {
   $this->category = $category;
  }
  
  /**
   * @return mixed
   */
  public function getThumbnail()
  {
   return $this->thumbnail;
  }
  /**
   * @param mixed $description
   */
  public function setThumbnail($thumbnail)
  {
   $this->thumbnail = $thumbnail;
  }

  /**
   * @return mixed
   */
  public function getDateCreated(): ?\DateTime
  {
   return $this->date_created;
  }

  /**
   * @param \DateTime $date_created
   * @return Post
   */
  public function setDateCreated(\DateTime $date_created): self
  {
   $this->date_created = $date_created;
   return $this;
  }

  /**
   * @return mixed
   */
  public function getDateUpdated(): ?\DateTime
  {
   return $this->date_updated;
  }

  /**
   * @param \DateTime $date_updated
   * @return Post
   */
  public function setDateUpdated(\DateTime $date_updated): self
  {
   $this->date_updated = $date_updated;
   return $this;
  }

  /**
   * @throws \Exception
   * @ORM\PrePersist()
   */
  public function beforeSave(){

   $this->create_date = new \DateTime('now', new \DateTimeZone('Africa/Casablanca'));
  }



  /**
   * Specify data which should be serialized to JSON
   * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
   * @return mixed data which can be serialized by <b>json_encode</b>,
   * which is a value of any type other than a resource.
   * @since 5.4.0
   */
  public function jsonSerialize()
  {
   return [
    "title" => $this->getTitle(),
    "category" => $this->getCategory(),
    "thumbnail" => $this->getThumbnail()
   ];
  }
 }