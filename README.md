#StockTickerAgent

*******
Members
*******

* Eddy Lau
* Joe Pelz
* Chih Tseng
 
**********
To-Do List
**********

* 3 HTML's
* 3 Controllers
  * Homepage
  * Stock Page
  * Player Page
* Each page requires a:
  * One Header
  * Navbar
   * Login 
  * Title
  * Two nested panels or pages done through methods in controller
  * One Footer

You want to have a controller for each main page. The nested pages or panels
should be done through methods in the controller. For example, your homepage
would have two additional methods (one per panel), your stock history page
would have separate methods for the movement and transactions.
Use a base controller, with a master view template providing the overall webpage
layout & placeholders for the “real” content on a page.
Use separate view templates for the different layouts (panels) your site will need.
Use a base model to provide consistent functionality across your data sources.

