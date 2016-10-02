<?php
    class Team
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        function getPlayers()
        {
            $players = array();
            $returned_players = $GLOBALS['DB']->query("SELECT * FROM players WHERE team_id = {$this->getId()};");
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

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO teams (name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_teams = $GLOBALS['DB']->query("SELECT * FROM teams;");
            $teams = array();
            foreach($returned_teams as $team) {
                $name = $team['name'];
                $id = $team['id'];
                $new_team = new Team($name, $id);
                array_push($teams, $new_team);
            }
            return $teams;
        }

        static function find($search_id)
        {
            $found_team = null;
            $teams = Team::getAll();
            foreach($teams as $team) {
                $team_id = $team->getId();
                if($team_id == $search_id) {
                    $found_team = $team;
                }
            }
            return $found_team;
        }
    }



?>
