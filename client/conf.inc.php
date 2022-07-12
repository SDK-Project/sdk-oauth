<?php

define('CLIENT_ID_SERV', '621e3b8d1f964');
define('CLIENT_SECRET_SERV', '621e3b8d1f966');
define('AUTH_URL_SERV', 'http://localhost:8080/auth');
define('ACCESS_TOKEN_URL_SERV', 'http://oauth-server:8080/token');
define('USER_URL_SERV', 'http://oauth-server:8080/me');
define('REDIRECT_URI_SERV', 'http://localhost:8081/callback');

define('CLIENT_ID_FB', '2332321786915136');
define('CLIENT_SECRET_FB', 'b767a3113b9d57571eeea5949438bdc6');
define('AUTH_URL_FB', 'https://www.facebook.com/v2.10/dialog/oauth');
define('ACCESS_TOKEN_URL_FB', 'https://graph.facebook.com/v2.10/oauth/access_token');
define('USER_URL_FB', 'https://graph.facebook.com/v2.10/me');
define('REDIRECT_URI_FB', 'http://localhost:8081/fb_callback');

define('CLIENT_ID_GIT', 'b6111aea773eeced7865');
define('CLIENT_SECRET_GIT', '26e0e2e809c7a9ccc9080708e410b9df88ad9038');
define('AUTH_URL_GIT', 'https://github.com/login/oauth/authorize');
define('ACCESS_TOKEN_URL_GIT', 'https://github.com/login/oauth/access_token');
define('USER_URL_GIT', 'https://api.github.com/user');
define('REDIRECT_URI_GIT', 'http://localhost:8081/git_callback');

define('CLIENT_ID_DS', '989170106129059901');
define('CLIENT_SECRET_DS', 'pQz2fXv0ef8xdz2bG_PhRdfkRNk4n7sT');
define('AUTH_URL_DS', 'https://discord.com/api/oauth2/authorize');
define('ACCESS_TOKEN_URL_DS', 'https://discord.com/api/oauth2/token');
define('USER_URL_DS', 'https://discord.com/api/users/@me');
define('REDIRECT_URI_DS', 'http://localhost:8081/ds_callback');

define('CLIENT_ID_GO', '727904560873-1im2ajo9g79bp0tugf7nad4t2pvpkrfs.apps.googleusercontent.com');
define('CLIENT_SECRET_GO', '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');
define('AUTH_URL_GO', 'https://accounts.google.com/o/oauth2/auth');
define('ACCESS_TOKEN_URL_GO', 'https://oauth2.googleapis.com/token');
define('USER_URL_GO', 'https://www.googleapis.com/oauth2/v1/userinfo');
define('REDIRECT_URI_GO', 'http://localhost:8081/go_callback');