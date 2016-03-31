################
StockTickerAgent
################

*******
Members
*******

* Eddy Lau
 * User Registration
  * Registration Page
  * Roles
* Joe Pelz
 * Buy
 * Sell
* Chih Tseng
 * Gameplay Page
 * Dashboard
* Dimitry Rakhlei
 * Portfolio
 
**********
To-Do List
**********

*Dashboard
	*Show current stocks
		*Value
	*Show active player
		*Name
		*Avatar
		*FIVE most recent transactions
	*Summary Information
		*Game #
		*Status
		
*Stocks
	*Show active stocks
	*Drill-down(see more info)
	*Movements
	*Transactions
	
	*BUYING STOCKS
		*send a POST request to BSX/buy with the following:
			*team: team code
			*token
			*player
			*stock
			*quantity
		*Check if player has sufficient cash
			*if sufficient
				*complete transaction
				*return stock certificate as XML document with the following:
					*team
					*player
					*stock
					*quantity
					*certificate
				*return receipt including
					*cash spent
					*certificate
			*else
				*error
	
	*SELLING STOCKS
		*Send a POST request to BSX/sell with the following:
	
*Portfolio
	*List of users
		*Drilldown
		*Transactions
			*Split
			*Delistings
	
*Player Login
	*Registration Page
	*Provide UNIQUE UserID
	
*Player Administration
	*Roles
		*Player
			*Anyone can do this
		*Admin
			*Player maintenance

			
*Agent Rgistration
	*App registers with the BSX server
	*If game is ready
		*send POST to register the following:
			*team
			*name
			*password
				*will be posted on D2L as a news item

