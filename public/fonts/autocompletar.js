/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generarComunicacion() {
    /*var url_base = 
             'https://www.googleapis.com/plus/v1/people/me';
 
          // The auth_token is the base64 encoded string for the API 
          // application.
          var auth_token = 'ya29.GltoBK1onB8ppLsXPmTOegLOdrMwssftPSsnNdyvlZeyO87NQWrTlTWAVa2geBK_RCSeMIV2knhRggIjfDXYBnF4iYW7t61jUl0ngr39Nb2E8icQDndIgiIeQTT3';
          auth_token = window.btoa(auth_token);
          var requestPayload = {
              // Enter your inContact credentials for the 'username' and 
              // 'password' fields.
              'grant_type': 'password',
              'username': 'YourUsernameHere',
              'password': 'YourPasswordHere',
              'scope': ''
          }*/
//}
//var ClientOAuth2 = document.getElementById('client').src;
var ClientOAuth2 = require('client');


var githubAuth = new ClientOAuth2({
  clientId: '919561790448-kijeulv7pto5bpkeqs5pfhli0lv6ludv.apps.googleusercontent.com',//La cadena de ID de cliente asignado por el proveedor
  clientSecret: 'Ww9j_Ax7ll2i-fmqfMiUxpKI',//El cliente serie secreta asignada por el proveedor (no requerido para token)
  accessTokenUri: 'ya29.GltoBO_GmSHYF0KS_PDg160ZOdBLsgbFLKddNj_58P7EzCfrsWOt-Rb8cfyVF4C30h1sLG7MXIK6D8-x8lSEBMQ3kvxizNF_tc8CLtKTg3v4sX20dpOsHveyF5dL',//La url para solicitar el token de acceso (no requerido para token)
  authorizationUri: '4/L13ulTGjAHvRYJU33bxCXlYKk_khxcKzBg0JTh2GLRQ',//La url para redirigir a los usuarios a autenticarse con el proveedor (sólo se requiere para tokene code)
  redirectUri: '',//una URL personalizada para el proveedor para redirigir a los usuarios volver a la aplicación (sólo se requiere para tokene code)
  scopes: ['notifications', 'gist']//Una serie de ámbitos para autenticar contra
});

// También se puede simplemente pasar el crudo `data` objeto en lugar de un argumento. 
//var token = githubAuth.createToken('access token', 'optional refresh token', 'optional token type', { data: 'raw user data' });
var token = githubAuth.createToken('ya29.GltoBO_GmSHYF0KS_PDg160ZOdBLsgbFLKddNj_58P7EzCfrsWOt-Rb8cfyVF4C30h1sLG7MXIK6D8-x8lSEBMQ3kvxizNF_tc8CLtKTg3v4sX20dpOsHveyF5dL', '1/08baYfzOeZhOXsOZgLCPeC_4Y9CfDxMF8Ih-IhhnntU', { data: 'raw user data' });

// establecer el token TTL.
token.expiresIn(1234) // Seconds.
token.expiresIn(new Date('2016-11-08')) // Date.

// Actualizar las credenciales de los usuarios y guardar el nuevo token de acceso y la información.
token.refresh().then(storeNewToken)

// Firmar una petición HTTP objeto estándar, la actualización de la dirección URL con el token de acceso 
// o añadir cabeceras de autorización, según el tipo de token. 
token.sign({
  method: 'get',
  url: 'https://api.github.com/users'
}) //=> { method, url, headers, ... }


var express = require('express')
var app = express()

app.get('/auth/github', function (req, res) {
  var uri = githubAuth.code.getUri()

  res.redirect(uri)
})

app.get('/auth/github/callback', function (req, res) {
  githubAuth.code.getToken(req.originalUrl)
    .then(function (user) {
      console.log(user) //=> { accessToken: '...', tokenType: 'bearer', ... }

     // Actualizar los usuarios actuales token de acceso. 
      user.refresh().then(function (updatedUser) {
        console.log(updatedUser !== user) //=> true
        console.log(updatedUser.accessToken)
      })

      // Firma solicitudes de API en nombre del usuario actual. 
      user.sign({
        method: 'get',
        url: 'http://example.com'
      })

      // // Debemos almacenar el token en una base de datos. 
      return res.send(user.accessToken)
    })
})


window.oauth2Callback = function (uri) {
  githubAuth.token.getToken(uri)
    .then(function (user) {
      console.log(user) //=> { accessToken: '...', tokenType: 'bearer', ... }

      // Realizar una solicitud a la API de GitHub para el usuario actual.
      return popsicle.request(user.sign({
        method: 'get',
        url: 'https://api.github.com/user'
      })).then(function (res) {
        console.log(res) //=> { body: { ... }, status: 200, headers: { ... } }
      })
    })
}
// Abre la página en una nueva ventana, a continuación, volver a redirigir una página que llama a nuestra función oauth2Callback` mundial '. 
window.open(githubAuth.token.getUri());

///Hacer una solicitud directa para el token de acceso en nombre del usuario que utiliza 
githubAuth.owner.getToken('blakeembrey', 'hunter2')
  .then(function (user) {
    console.log(user) //=> { accessToken: '...', tokenType: 'bearer', ... }
  })
  
  //Obtener el token de acceso para la aplicación utilizando githubAuth.jwt.getToken(jwt [, options ]).
  githubAuth.credentials.getToken()
  .then(function (user) {
    console.log(user) //=> { accessToken: '...', tokenType: 'bearer', ... }
  })
  
}