<?php
    class Player
    {
        private $name;
        private $id;
        private $age;
        private $email;
        private $team_id;

        function __construct($name, $id = null, $age, $email, $team_id)
        {
            $this->name = $name;
            $this->id = $id;
            $this->age = $age;
            $this->email = $email;
            $this->team_id = $team_id;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function getAge()
        {
            return $this->age;
        }

        function getEmail()
        {
            return $this->email;
        }

        function getTeamId()
        {
            return $this->team_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO players (name, age, email, team_id) VALUES ('{$this->getName()}', {$this->getAge()}, '{$this->getEmail()}', {$this->getTeamId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_players = $GLOBALS['DB']->query("SELECT * FROM players;");
            $players = array();
            foreach($returned_players as $player) {
                $name = $player['name'];
                $id = $player['id'];
                $age = $player['age'];
                $email = $player['email'];
                $team_id = $player['team_id'];
                $new_player = new Player($name, $id, $age, $email, $team_id);
                array_push($players, $new_player);
            }
            return $players;
        }

        static function find($search_id)
        {
            $found_player = null;
            $players = Player::getAll();
            foreach($players as $player) {
                $player_id = $player->getId();
                if($player_id == $search_id) {
                    $found_player = $player;
                }
            }
            return $found_player;
        }
    }



?>
