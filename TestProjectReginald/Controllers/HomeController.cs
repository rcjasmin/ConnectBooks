using COMMONS;
using Intuit.Ipp.Data;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace TestProjectReginald.Controllers {
    public class HomeController : Controller {
        public ActionResult Index()
        {
            string realmId = Request.QueryString["realmId"] ?? "";
            ViewBag.realmId = realmId;

            if (TempData["Token"] != null)
            {
                ViewBag.Token = TempData["Token"].ToString();
            }

            if (TempData["Customers"] != null)
            {
                ViewBag.Customers = (List<Customer>)TempData["Customers"];
            }
            else {
                ViewBag.CustomersFromDB = new DAL().GetCustomers();
            }

            if (TempData["SuccesRefresh"] != null)
            {
                ViewBag.Message = (string)TempData["SuccesRefresh"];
            }

            return View();
        }
    }
}