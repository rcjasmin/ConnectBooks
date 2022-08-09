using COMMONS;
using Intuit.Ipp.OAuth2PlatformClient;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Threading.Tasks;
using System.Web;
using System.Web.Mvc;

namespace TestProjectReginald.Controllers
{
    
    public class CallbackController : Controller {

        public async Task<ActionResult> Index()
        {
            string code = Request.QueryString["code"] ?? "";
            string realmId = Request.QueryString["realmId"] ?? "";
            var tokenResponse = await QuickBooksController.auth2Client.GetBearerTokenAsync(code);
            var access_token = tokenResponse.AccessToken;
            var refresh_token = tokenResponse.RefreshToken;

            new DAL().SaveToken(access_token);
            TempData["Token"] = access_token;

            return RedirectToAction("Index", "Home", new { realmId = realmId });
        }


    }
}