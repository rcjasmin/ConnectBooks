using COMMONS;
using Intuit.Ipp.OAuth2PlatformClient;
using System.Collections.Generic;
using System.Configuration;
using System.Web.Mvc;

namespace TestProjectReginald.Controllers {
    public class QuickBooksController : Controller {
        //Instantiate OAuth2Client object with clientId, clientsecret, redirectUrl and environment
        public static OAuth2Client auth2Client = new OAuth2Client(ConfigurationManager.AppSettings["clientid"], ConfigurationManager.AppSettings["clientsecret"] , ConfigurationManager.AppSettings["redirectUrl"], ConfigurationManager.AppSettings["appEnvironment"] );

        //Generate authorize url to get the OAuth2 code
        public ActionResult InitiateAuth(string submitButton)
        {
            List<OidcScopes> scopes = new List<OidcScopes>();
            scopes.Add(OidcScopes.Accounting);
            string authorizeUrl = auth2Client.GetAuthorizationURL(scopes);
            return Redirect(authorizeUrl);
        }
    }
}