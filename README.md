################
StockTickerAgent
################

*******
Members
*******

* Eddy Lau
* Joe Pelz
* Chih Tseng
* Dimitry Rakhlei
 
**********
To-Do List
**********


* Models: 1 model per DB table
  * movements
  * players
  * stocks
  * transactions

* 3 Controllers
  * Homepage
  * Stock Page
  * Player Page
  * Login page or panel or popup
 
  
* Each page requires a:
  * One Header
  * Navbar
   * Login 
  * Title
  * Two nested panels or pages done through methods in controller
  * One Footer
  
  
 * The homepage would have:
   * Two additional methods
   * One per panel
  
  
 * The stock history page would have:
   * One method for movement
   * One method for transactions
 
 * Master view template
  * Provides a overall webpage layout and placeholders for the "real" conten
  * Use separate view templates for different layouts
 
 * Base model for consistent functionality