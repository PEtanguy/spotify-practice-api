<?php

namespace App\Controller;

use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use SpotifyWebAPI\Session;

class AuthController extends AbstractController
{
  // src/Controller/AuthController
  private $spotifyParams;
  private $spotify;

  public function __construct()
  {
      $this->spotifyParams = [
          'client_id' => 'e1470874f95a406eab5d0854133a73fa',
          'client_secret' => '6127294c7fe348c791d73e8d6ace52a6',
          'scope' => ['user-read-email','user-read-private','playlist-read-private',
                       'playlist-read-collaborative','playlist-modify-public',
                       'playlist-modify-private','user-follow-read','user-follow-modify', 'user-top-read']
      ];

      $this->spotify = new Session(
        $this->spotifyParams['client_id'],
        $this->spotifyParams['client_secret'],
        'http://127.0.0.1:8000/login/oauth'
    );
  }
    /**
     * @Route("/login", name="login")
     */
    public function login( SessionInterface $session )
    {
        $options = [
            'scope' => $this->spotifyParams['scope']
        ];

        $spotify_auth_url = $this->spotify->getAuthorizeUrl($options);
        return $this->render('auth/login.html.twig', array(
            'spotify_auth_url' => $spotify_auth_url
        ));
    }

    /**
     * @Route("/login/oauth", name="oauth")
     */
    public function oauth(Request $request, SessionInterface $session)
    {
        $accessCode = $request->get('code');
        $session->set('accessCode', $accessCode); // symfony session
        dump($session);
        $this->spotify->requestAccessToken($accessCode);
        $accessToken = $this->spotify->getAccessToken();
        $session->set('accessToken', $accessToken); // symfony session

        return $this->redirectToRoute('profile');
    }


    /**
     * @Route("/profile", name="profile")
     */
    public function profile(Request $request, SessionInterface $session )
    {
        $accessToken = $session->get('accessToken');
        if( ! $accessToken ) {
            $session->getFlashBag()->add('error', 'Invalid authorization');
            $this->redirectToRoute('login');
        }

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);
        $followed = $api->getUserFollowedArtists();
        $top = $api->getMyTop('artists');
        $top = json_decode(json_encode($top), true)["items"];

        $me = $api->me();

        dump($top);

        return $this->render('auth/profile.html.twig', array(
            'me' => $me,
            'followed' => $followed,
            'top' => $top
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout( SessionInterface $session )
    {
        $session->clear();
        $session->getFlashBag()->add('success', 'You have successfully logged out');

        return $this->redirectToRoute('login');
    }

}
