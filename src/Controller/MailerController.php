<?php

namespace App\Controller;


use GuzzleHttp\Client;
use Microsoft\Graph\Graph;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function test_sending_email()
    {
        $graph = new Graph();
        $access_token = $this->getAcessToken("","","");
        $graph->setAccessToken($access_token);
        $subject = "This is a Subject";
        $body = "This is the Mail Body";
        $name = "El Hadji Hady SARR";
        $email = "";
        $mailBody = array( "Message" => array(
            "subject" => $subject,
            "body" => array(
                "contentType" => "html",
                "content" => $body
            ),
            "sender" => array(
                "emailAddress" => array(
                    "name" => $name,
                    "address" => $email
                )
            ),
            "from" => array(
                "emailAddress" => array(
                    "name" => $name,
                    "address" => $email
                )
            ),
            "toRecipients" => array(
                array(
                    "emailAddress" => array(
                        "name" => $name,
                        "address" => "prepreilliffummu-2282@yopmail.com"

                    )
                )
            )
        )
        );
        $user_id = "";
        $graph->createRequest("POST", "/users/".$user_id."/sendMail")
            ->attachBody($mailBody)
            ->execute();
        return json_encode($graph);
    }
    private function getAcessToken($tenantId,$clientId,$clientSecret)
    {
        $guzzle = new Client();
        $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token?api-version=beta';
        $token = json_decode($guzzle->post($url, [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'resource' => 'https://graph.microsoft.com/',
                'grant_type' => 'client_credentials',
            ],
        ])->getBody()->getContents());
        return $token->access_token;
    }
}
