using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace COMMONS {
    public class DAL {

        readonly string path = @"C:\ConnectBooks\Token.txt";
        public string GetToken()
        {
            var token = "";
            if (File.Exists(path))
            {
                using (TextReader tr = new StreamReader(path))
                {
                    token = tr.ReadLine();
                }
            }
            return token;
        }

        public void SaveToken(string token) {
            using (StreamWriter sw = new StreamWriter(path))
            {
                sw.Write(token);
            }
        }

        public void SaveCustomer(customer c) {
            using (var context = new connectbooksEntities())
            {
                context.customers.Add(c);
                context.SaveChanges();
            }
        }

        public void DeleteCustomers()
        {
            using (var context = new connectbooksEntities())
            {
                var rows = from u in context.customers
                        select u;
                foreach (var row in rows)
                {
                    context.customers.Remove(row);
                }
                context.SaveChanges();
            }
        }

        public List<CustomerData> GetCustomers()
        {
            using (var context = new connectbooksEntities())
            {
                var q = from u in context.customers
                        select new CustomerData() { GivenName = u.GivenName, FamilyName = u.FamilyName, CompanyName= u.CompanyName  };
                return q.ToList();
            }
        }

    }
}
