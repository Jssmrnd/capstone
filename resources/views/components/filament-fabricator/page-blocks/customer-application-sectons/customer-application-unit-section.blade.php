<h3>UNIT TO BE FINANCED</h3>
<form>
    <form>
        <label for="unit-model">UNIT / MODEL:</label>
        <select id="unit-model" name="unit-model">
            <option value="">Select Model</option>
            <option value="Model A">Model A</option>
            <option value="Model B">Model B</option>
            <option value="Model C">Model C</option>
        </select>
        <br>
        <label for="term">Term:</label>
        <select id="term" name="term">
            <option value="">Select Term</option>
            <option value="12">12 Months</option>
            <option value="24">24 Months</option>
            <option value="36">36 Months</option>
            <!-- Add more term options as needed -->
        </select>
        <br>
        <label for="ttl-dp">TTL D/P:</label>
        <select id="ttl-dp" name="ttl-dp">
            <option value="">Select TTL D/P</option>
            <option value="10000">10,000 PHP</option>
            <option value="20000">20,000 PHP</option>
            <option value="30000">30,000 PHP</option>
            <!-- Add more total down payment options as needed -->
        </select>
        <br>
        <label for="srp">SRP:</label>
        <select id="srp" name="srp">
            <option value="">Select SRP</option>
            <option value="100000">100,000 PHP</option>
            <option value="150000">150,000 PHP</option>
            <option value="200000">200,000 PHP</option>
            <!-- Add more SRP options as needed -->
        </select>
        <br>
        <label for="mo-amort">Monthly Amortization:</label>
        <select id="mo-amort" name="mo-amort">
            <option value="">Select Monthly Amortization</option>
            <option value="5000">5,000 PHP</option>
            <option value="6000">6,000 PHP</option>
            <option value="7000">7,000 PHP</option>
            <!-- Add more monthly amortization options as needed -->
        </select>
        <br>
        <label for="amt-fin">Amt. Fin.:</label>
        <select id="amt-fin" name="amt-fin">
            <option value="">Select Amt. Fin.</option>
            <option value="50000">50,000 PHP</option>
            <option value="60000">60,000 PHP</option>
            <option value="70000">70,000 PHP</option>
            <!-- Add more Amt. Fin. options as needed -->
        </select>
        <br>
        <label>Type:</label>
        <input type="radio" id="type-new" name="type" value="New">
        <label for="type-new">New</label>
        <input type="radio" id="type-repeat" name="type" value="Repeat">
        <label for="type-repeat">Repeat</label>
        <br>
        <label>Mode of Payment:</label>
        <input type="radio" id="mode-office" name="mode" value="Office">
        <label for="mode-office">Office</label>
        <input type="radio" id="mode-field" name="mode" value="Field">
        <label for="mode-field">Field</label>
        <input type="radio" id="mode-bank" name="mode" value="Bank">
        <label for="mode-bank">Bank</label>
        <br>
    </form>