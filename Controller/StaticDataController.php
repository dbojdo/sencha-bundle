<?php
namespace Webit\Bundle\SenchaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Webit\Bundle\SenchaBundle\Component\Store\StoreResponse;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

class StaticDataController extends Controller {
    public function exposeStaticDataAction() {
        $data = $this->container->get('webit_sencha.static_data_exposer')->getExposedData();
        
        $json = new StoreResponse();
            $json->setData($data);
    
        $context = SerializationContext::create()->setGroups(array('store','static-data'));
    
        $r = new Response();
        $r->headers->add(array('Content-Type'=>'application/json'));
        $r->setStatusCode(200,'OK');
        $r->setContent($this->get('serializer')->serialize($json,'json',$context));
    
        return $r;
    }
}
?>
