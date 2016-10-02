<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Team.php";
    require_once __DIR__."/../src/Player.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=doe_teams';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('teams' => Team::getAll()));
    });

    $app->get("/joinTeam/{id}", function($id) use ($app) {
        $team = Team::find($id);
        return $app['twig']->render('joinTeam.html.twig', array('team' => $team));
    });

    $app->post("/addPlayer/{id}", function($id) use ($app) {
        $team = Team::find($id);
        $name = $_POST['name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $team_id = $team->getId();
        $new_player = new Player($name, null, $age, $email, $team_id);
        $new_player->save();
        return $app['twig']->render('index.html.twig', array('teams' => Team::getAll()));
    });

    return $app;
?>
