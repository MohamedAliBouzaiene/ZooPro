  
<?php
class planteM
{
    private $db;
    private $idP;
    private $nomP;
    private $longevite;
    private $origine;
    private $taille;
    private $famille;
    private $image;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getIdP(){
        echo $this->idP;
    }
    public function getNomP(){
        echo $this->nomP;
    }

    public function getLongevite(){
        echo $this->longevite;
    }

    public function getOrigine(){
        echo $this->origine;
    }

    public function getTaille(){
        echo $this->taille;
    }

    public function getFamille(){
        echo $this->famille;
    }

    public function getimage(){
        echo $this->image;
    }


    public function addplanteC($data)
    {
        $this->db->query('INSERT INTO plante (nomP,longevite,origine,taille,famille,image) VALUES(:nomP,:longevite,:origine,:taille,:famille,:image)');

        //Bind values
        $this->db->bind(':nomP', $data['nomP']);
        $this->db->bind(':longevite', $data['longevite']);
        $this->db->bind(':origine', $data['origine']);
        $this->db->bind(':taille', $data['taille']);
        $this->db->bind(':famille', $data['famille']);
        $this->db->bind(':image', $data['image']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

   

    public function afficherplante(){
        $this->db->query('SELECT * FROM plante ');
        return $this->db->resultSet();
    }


    public function deleteplante($idP){
        $this->db->query('DELETE FROM plante WHERE idP = :idP');
        $this->db->bind(':idP', $idP);
        $this->db->execute();
    }
    
    public function findUserByIDUpdate($idP)
    {
        //Prepared statement
        $this->db->query('SELECT * FROM plante WHERE idP != :idP;');

        $this->db->bind(':idP', $idP);
        $this->db->execute();
    }


    public function updateplante($data){
        $this->db->query('UPDATE plante SET nomP =:nomP,longevite =:longevite,origine =:origine,taille=:taille, famille=:famille,image=:image WHERE idP = :idP ');
        //Bind values
        $this->db->bind(':nomP', $data['nomP']);
        $this->db->bind(':origine', $data['origine']);
        $this->db->bind(':longevite', $data['longevite']);
        $this->db->bind(':taille', $data['taille']);
        $this->db->bind(':famille', $data['famille']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':idP', $data['idP']);

        //Execute function
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    

    public function listespeceID()
    {
        $this->db->query('SELECT idE FROM `espece`');
        return $this->db->resultSet();
    }


}