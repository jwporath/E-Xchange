## What is E-XChange?

E-XChange is a website based on Hasan Jamil’s description of the
CS-360 traditional project, BarterDB. E-XChange is a website for
trading items anonymously. The platform will allow users to create
accounts, establish partnerships, and make posts stating what they
have to trade and what items they are looking for in return. E-XChange 
will automatically pair compatible posts and compare
values to ensure a fair trade. Once a trade has begun, each user
will send their items to E-XChange along with identifying hash
codes. Once all parties have sent in their items, E-XChange will
distribute the items to their intended recipients, allowing the trade
to be completed without either party needing any information on
the other.

### Installation

1. Download and install [XAMPP](https://www.apachefriends.org/download.html)

2. Clone the repo. I recommend cloning into a subfolder inside of XAMPP's htdocs folder as follows:
   ```sh
   git clone https://github.com/jwporath/E-Xchange.git C:/xampp/htdocs/E-XChange
   ```
3. Start Apache and MySQL in XAMPP

![alt text](<xampp start.gif>)

4. Import the database template using PHPMyAdmin. Do this by pressing "admin" next to MySQL in XAMPP. Then select "new" in the left sidebar to create a blank database. Name it "E-XChange". Finally, use the "Import" button along the top of the screen to import the template provided in the E-XChange Database Template folder of the repo.

![alt text](<Readme Images/phpmyadmin.gif>)

![alt text](<Readme Images/import.gif>)

5. Open your browser and navigate to the webpage. If you used the location in step 2, then you should use the following url:
   ```js
   http://localhost/E-Xchange/
   ```