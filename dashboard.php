<?php
include('dashboard_header.php');


// Fetch data from the database
$queries = [
    "SELECT COUNT(*) as total FROM books" => 'total_books',
    "SELECT COUNT(DISTINCT author) as total FROM books" => 'total_authors',
    "SELECT COUNT(DISTINCT publisher) as total FROM books" => 'total_publishers',
    "SELECT COUNT(DISTINCT category) as total FROM books" => 'total_categories'
];

$stats = [];
foreach ($queries as $query => $key) {
    $result = pg_query($conn, $query);
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $stats[$key] = $row['total'];
    } else {
        $stats[$key] = 0; // Default to 0 if no records found
    }
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Total Books</h6>
                    <h2><?php echo $stats['total_books']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Total Authors</h6>
                    <h2><?php echo $stats['total_authors']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Total Publishers</h6>
                    <h2><?php echo $stats['total_publishers']; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Total Categories</h6>
                    <h2><?php echo $stats['total_categories']; ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h6>Enable/Disable Download</h6>
                    <label for="toggleDownload" id="toggleLabel">Enable Download</label>
                    <input type="checkbox" id="toggleDownload" onclick="toggleDownload()">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        padding: 20px;
        border-radius: 10px;
        margin: 10px;
        background: #fff;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 8px;
        text-align: center;
    }
    .card-body h6 {
        margin: 0;
        font-size: 16px;
        color: #6c757d;
    }
    .card-body h2 {
        margin: 10px 0 0;
        font-size: 36px;
        color: #333;
    }
</style>

<script>
    function toggleDownload() {
        // Get the checkbox
        const checkbox = document.getElementById("toggleDownload");

        // Get the label
        const label = document.getElementById("toggleLabel");

        // Update the label and save the state
        if (checkbox.checked) {
            label.innerText = "Disable Download";
            localStorage.setItem("downloadEnabled", "true");
        } else {
            label.innerText = "Enable Download";
            localStorage.setItem("downloadEnabled", "false");
        }

        // Update download buttons on other pages
        updateDownloadButtons();
    }

    function updateDownloadButtons() {
        // Check the state and update buttons accordingly
        const downloadEnabled = localStorage.getItem("downloadEnabled") === "true";
        const downloadButtons = document.querySelectorAll(".downloadBtn");

        downloadButtons.forEach(button => {
            button.disabled = !downloadEnabled;
        });
    }

    window.onload = function() {
        // Set the initial state on page load
        const downloadEnabled = localStorage.getItem("downloadEnabled") === "true";
        document.getElementById("toggleDownload").checked = downloadEnabled;
        document.getElementById("toggleLabel").innerText = downloadEnabled ? "Disable Download" : "Enable Download";
        updateDownloadButtons();
    };
</script>

<?php
include('dashboard_footer.php');
?>
