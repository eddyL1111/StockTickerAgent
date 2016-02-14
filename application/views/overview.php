<div class="ui center aligned four column grid">
    <div class="column"></div>
    <div class="column">
        <h2>Stocks</h2>
        <div class="row">
            <form action="stock" method="post">
            <table class="ui celled table">
            <thead>
              <tr><th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Value</th>
            </tr></thead>
            <tbody>
                {stocks}
                    <tr>
                        <td><input type="submit" name="stock_type" class="submitButton" value="{code}"></td>
                        <td>{name}</td><td>{category}</td><td>{value}</td>
                    </tr>
                {/stocks}
            </tbody>
            </table>
            </form>

        </div>
    </div>
    <div class="column">
        <h2>Players</h2>
        <div class="row">
            <table class="ui celled table">
            <thead>
              <tr><th>Player</th>
              <th>Cash</th>
            </tr></thead>
            <tbody>
                {players}
                <tr><td><a href="/portfolio/{name}">{name}</a></td><td>{cash}</td></tr>
                {/players}
            </tbody>
            </table>
        </div>
    </div>
    <div class="column"></div>
</div>