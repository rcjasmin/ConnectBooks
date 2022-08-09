using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace TestProjectReginald.Models {
    public class CustomerData {

        string GivenName { get; set; }
        string FamilyName { get; set; }
        string CompanyName { get; set; }


        public CustomerData(string givenName, string familyName, string companyName)
        {
            GivenName = givenName;
            FamilyName = familyName;
            CompanyName = companyName;
        }
    }
}