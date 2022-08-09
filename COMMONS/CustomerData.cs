using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace COMMONS {
    public class CustomerData {

        public string GivenName { get; set; }
        public string FamilyName { get; set; }
        public string CompanyName { get; set; }


        public CustomerData(string givenName, string familyName, string companyName)
        {
            GivenName = givenName;
            FamilyName = familyName;
            CompanyName = companyName;
        }

        public CustomerData()
        {
        }
    }
}
