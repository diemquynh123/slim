<?php
namespace classes\Controller;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Database\Query\Builder;
use Slim\Views\PhpRenderer;
use Slim\Http\Response;
use Slim\Http\Request;


 class AdController
 {
 	protected $view;
 	protected $container;
    protected $table;


   // constructor receives container instance
   public function __construct() {
       $this->view = new PhpRenderer("../templates");
       
   }

 	 public function index(Request $request, Response $response, array $args){
 	 	return  $this->view->render($response,'index.phtml'); 	 	
 	 }

 	public function blog(Request $request, Response $response, array $args){
 		$rs = $this->db->query("select * from blog");
	
		$blogEntries = array();
		while($row = $rs->fetch_assoc()){
				$blogEntries[] = $row;
			}
		
		$data = array(
			"main_heading" => "Blog",
			"blog_entries" =>$blogEntries,
		);
		
		return $this->view->render($response, 'blog.html',$data);
 	}



 	public function getLogin($request,$response,$args){
 
	return $this->view->render($response, 'login.phtml');

 	}


 	public function postLogin($request,$response,$args){
 		  $usuario = ($POST['usuario']);
	    $input = $request->getParsedBody();
	    $sth = $this->db->prepare("SELECT * FROM aldroges8.oficina_virtual_usuarios WHERE 
	    usuario='".$usuario."'");
	    $result = $sth->execute();

	    $row_cnt = $result->num_rows;
	    if ($row_cnt>0){
	      return $this->response->withJson(array("ok"=>"acceso autorizado"));

	    }else{
	      return $this->response->withJson(array("error"=>"acceso negado"));

	    }
 	}
 }
