using COMMONS;
using Intuit.Ipp.Core;
using Intuit.Ipp.Data;
using Intuit.Ipp.QueryFilter;
using Intuit.Ipp.Security;
using System;
using System.Collections.Generic;
using System.Configuration;
using System.Linq;
using System.Web.Mvc;


namespace TestProjectReginald.Controllers {
    public class ServiceController : Controller {
        public ActionResult Index(string realmId)
        {
            string access_token = new DAL().GetToken();
            OAuth2RequestValidator oauthValidator = new OAuth2RequestValidator(access_token);
            ServiceContext serviceContext = new ServiceContext(realmId, IntuitServicesType.QBO, oauthValidator);

            serviceContext.IppConfiguration.MinorVersion.Qbo = ConfigurationManager.AppSettings["apiMinorVersion"];
            serviceContext.IppConfiguration.BaseUrl.Qbo = ConfigurationManager.AppSettings["apiBaseUrl"];

            QueryService<Customer> querySvc = new QueryService<Customer>(serviceContext);
            List<Customer> customers = querySvc.ExecuteIdsQuery("SELECT * FROM Customer").ToList();

            TempData["Customers"] = customers;
            return RedirectToAction("Index", "Home", new { realmId = realmId });
        }

        public ActionResult Refresh(string realmId)
        {
            DAL dal = new DAL();
            string access_token = dal.GetToken();
            OAuth2RequestValidator oauthValidator = new OAuth2RequestValidator(access_token);
            ServiceContext serviceContext = new ServiceContext(realmId, IntuitServicesType.QBO, oauthValidator);

            serviceContext.IppConfiguration.MinorVersion.Qbo = ConfigurationManager.AppSettings["apiMinorVersion"];
            serviceContext.IppConfiguration.BaseUrl.Qbo = ConfigurationManager.AppSettings["apiBaseUrl"];

            QueryService<Customer> querySvc = new QueryService<Customer>(serviceContext);
            List<Customer> customersList = querySvc.ExecuteIdsQuery("SELECT * FROM Customer").ToList();

            dal.DeleteCustomers();

            foreach (Customer c in customersList)
            {
                customer cc = new customer() { Id = 0, GivenName = !string.IsNullOrEmpty(c.GivenName) ? c.GivenName : "", FamilyName = !string.IsNullOrEmpty(c.FamilyName) ? c.FamilyName : "", CompanyName = !string.IsNullOrEmpty(c.CompanyName) ? c.CompanyName : "", CreateDate = DateTime.Now };
                dal.SaveCustomer(cc);
            }

            TempData["SuccesRefresh"] = "Data Refreshed into database Successfuly.";
            return RedirectToAction("Index", "Home", new { realmId = realmId });
        }
    }
}