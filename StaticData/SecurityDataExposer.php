<?php
namespace Webit\Bundle\SenchaBundle\StaticData;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Webit\WitCrm\UserBundle\Entity\User;

class SecurityDataExposer implements StaticDataExposerInterface
{

    /**
     *
     * @return SecurityContextInterface
     */
    private $context;
    
    /**
     *
     * @var string
     */
    private $userModel;

    public function __construct(SecurityContextInterface $context, $userModel)
    {
        $this->context = $context;
        $this->userModel = $userModel;
    }

    /**
     *
     * @return array<key, data>
     */
    public function getExposedData()
    {
        $data = array(
            'security' => array(
                'user-model' => '',
                'user-data' => array()
            )
        );
        $token = $this->context->getToken();
        
        $data['security']['user-model'] = $this->userModel;
        if ($token && $token->getUser()) {
            $data['security']['user-data'] = $token->getUser();
        }
        
        return $data;
    }
}
