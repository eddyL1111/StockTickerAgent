<div class="ui center aligned two column grid">
    <div class="column">
        <h2>Stocks</h2>
        <div class="row">
            <table class="ui celled table">
            <thead>
              <tr><th>Code</th>
              <th>Name</th>
              <th>Category</th>
              <th>Value</th>
            </tr></thead>
            <tbody>
                {stocks}
                <tr><td><a href="/stock/history/{code}">{code}</a></td><td>{name}</td><td>{category}</td><td>{value}</td></tr>
                {/stocks}
            </tbody>
            </table>
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
</div>