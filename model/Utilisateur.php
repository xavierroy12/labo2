<?php


Class Utilisateur {
    private $id_utilisateur;
    private $nom;
    private $prenom;
    private $courriel;
    private $mdp;
    private $est_actif;
    private $role_utilisateur;
    private $type_utilisateur;
    private $token;

    public function __construct($params = array()){
  
        foreach($params as $k => $v){

            $methodName = "set_" . $k;
            if(method_exists($this, $methodName)) {
                $this->$methodName($v);
            }   
        }
    }


    /**
     * Get the value of id_utilisateur
     */ 
    public function getId_utilisateur()
    {
        return $this->id_utilisateur;
    }

    /**
     * Set the value of id_utilisateur
     *
     * @return  self
     */ 
    public function setId_utilisateur($id_utilisateur)
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of courriel
     */ 
    public function getCourriel()
    {
        return $this->courriel;
    }

    /**
     * Set the value of courriel
     *
     * @return  self
     */ 
    public function setCourriel($courriel)
    {
        $this->courriel = $courriel;

        return $this;
    }

    /**
     * Get the value of mdp
     */ 
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * Set the value of mdp
     *
     * @return  self
     */ 
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;

        return $this;
    }

    /**
     * Get the value of est_actif
     */ 
    public function getEst_actif()
    {
        return $this->est_actif;
    }

    /**
     * Set the value of est_actif
     *
     * @return  self
     */ 
    public function setEst_actif($est_actif)
    {
        $this->est_actif = $est_actif;

        return $this;
    }

    /**
     * Get the value of role_utilisateur
     */ 
    public function getRole_utilisateur()
    {
        return $this->role_utilisateur;
    }

    /**
     * Set the value of role_utilisateur
     *
     * @return  self
     */ 
    public function setRole_utilisateur($role_utilisateur)
    {
        $this->role_utilisateur = $role_utilisateur;

        return $this;
    }

    /**
     * Get the value of type_utilisateur
     */ 
    public function getType_utilisateur()
    {
        return $this->type_utilisateur;
    }

    /**
     * Set the value of type_utilisateur
     *
     * @return  self
     */ 
    public function setType_utilisateur($type_utilisateur)
    {
        $this->type_utilisateur = $type_utilisateur;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}