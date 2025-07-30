document.addEventListener('DOMContentLoaded', function () {
  const urlParams = new URLSearchParams(window.location.search);

  // --- LOGIN Home ---
  const error = urlParams.get('error');
  if (error) {
    Swal.fire({
      icon: 'error',
      title: 'Login Failed',
      text: decodeURIComponent(error),
      confirmButtonColor: '#d33',
    });
  }

  // --- Dashboard Status Alert ---
  const status = urlParams.get('status');
  if (status === 'success') {
    Swal.fire('Success!', 'Item added successfully!', 'success');
  } else if (status === 'error') {
    Swal.fire('Error!', 'Failed to add item or duplicate asset code.', 'error');
  }

  // --- Reload Title Click ---
  const refreshTitle = document.getElementById("refresh-title");
  if (refreshTitle) {
    refreshTitle.addEventListener("click", () => location.reload());
  }

  // --- Live Search with Debounce ---
  const searchInput = document.getElementById("searchInput");
  const resultsBox = document.getElementById("searchResults");
  let debounceTimeout;

  if (searchInput && resultsBox) {
    searchInput.addEventListener("input", function () {
      clearTimeout(debounceTimeout);
      debounceTimeout = setTimeout(() => {
        const query = this.value.trim();
        if (query.length < 2) {
          resultsBox.innerHTML = '';
          return;
        }

        fetch("search.php?q=" + encodeURIComponent(query))
          .then(res => res.json())
          .then(data => {
            resultsBox.innerHTML = '';
            if (data.length === 0) {
              resultsBox.innerHTML = '<div class="list-group-item disabled bg-secondary text-white">No results found</div>';
              return;
            }

            data.forEach(item => {
              const entry = document.createElement("a");
              entry.href = `${item.table}.php?highlight=${item.id}`;
              entry.className = "list-group-item list-group-item-action";
              entry.textContent = `${item.assetcode} - ${item.accountable_person} [${item.table}]`;
              resultsBox.appendChild(entry);
            });
          })
          .catch(err => {
            console.error("Search fetch error:", err);
            resultsBox.innerHTML = '<div class="list-group-item disabled bg-danger text-white">Search error. Please try again.</div>';
          });
      }, 300);
    });

    document.addEventListener("click", function (e) {
      if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
        resultsBox.innerHTML = '';
      }
    });
  }

  // --- Expand/Collapse View Specs on Row Click ---
  const buttons = document.querySelectorAll('.toggle-specs-btn');
  buttons.forEach(button => {
    button.addEventListener('click', function () {
      const assetcode = this.dataset.assetcode;
      const table = this.dataset.table;
      const id = this.dataset.id;

      const row = document.getElementById(`specs-${id}`);
      const content = document.getElementById(`specs-content-${id}`);

      if (!row || !content) return;

      // Toggle row visibility
      if (row.classList.contains('show')) {
        row.classList.remove('show');
        return;
      }

      // Hide other rows
      document.querySelectorAll('.specs-row.show').forEach(r => r.classList.remove('show'));

      // Load if not loaded
      if (content.dataset.loaded === "false") {
        content.innerHTML = "Loading specs...";

        fetch(`get_device_details.php?assetcode=${encodeURIComponent(assetcode)}&table=${encodeURIComponent(table)}`)
          .then(response => response.json())
          .then(data => {
            if (data.error) {
              content.innerHTML = `<span class="text-danger">${data.error}</span>`;
            } else {
              content.innerHTML = `
                <div class="d-flex flex-wrap gap-4">
                  <div><strong>Model:</strong> ${data.model}</div>
                  <div><strong>Line Type:</strong> ${data.line_type}</div>
                  <div><strong>Location:</strong> ${data.loc}</div>
                  <div><strong>Status:</strong> ${data.stat}</div>
                </div>`;
              content.dataset.loaded = "true";
            }
          })
          .catch(error => {
            content.innerHTML = `<span class="text-danger">Error fetching data.</span>`;
            console.error(error);
          });
      }

      row.classList.add('show');
    });
  });

  // --- Auto Expand Highlighted Row ---
  const highlightId = urlParams.get("highlight");
  if (highlightId) {
    let attempts = 0;
    const tryClick = () => {
      const button = document.querySelector(`.toggle-specs-btn[data-id="${highlightId}"]`);
      if (button) {
        button.click();
      } else if (attempts < 5) {
        attempts++;
        setTimeout(tryClick, 300);
      }
    };
    tryClick();
  }

  // --- Show/Hide Form Fields by Table ---
  const tableSelect = document.getElementById("table");
  if (tableSelect) {
    tableSelect.addEventListener("change", function () {
      const selected = this.value;
      const telephoneFields = document.getElementById("telephone-fields");
      const commonFields = document.getElementById("common-fields");

      if (commonFields) commonFields.style.display = "block";
      if (telephoneFields) telephoneFields.style.display = selected === "telephone" ? "block" : "none";
    });
  }

  // --- Highlight Current Page Bookmark ---
  const path = window.location.pathname;
  const bookmarkClasses = {
    "desktop.php": ".bookmarkd",
    "printer.php": ".bookmarkp",
    "telephone.php": ".bookmarkt",
    "laptop.php": ".bookmarkl",
    "cctv.php": ".bookmarkc",
    "dvr.php": ".bookmarkdv",
    "server.php": ".bookmarksv",
    "software.php": ".bookmarksf",
    "manageswitch.php": ".bookmarkms"
  };
  for (const key in bookmarkClasses) {
    if (path.endsWith(key)) {
      const bookmark = document.querySelector(bookmarkClasses[key]);
      if (bookmark) bookmark.classList.add("active-bookmark");
      break;
    }
  }

  // --- Refresh Buttons ---
  ["refresh-desktop", "refresh-telephone", "refresh-printer"].forEach(id => {
    const btn = document.getElementById(id);
    if (btn) {
      btn.addEventListener("click", function () {
        const url = new URL(window.location);
        url.searchParams.delete('highlight');
        window.location.href = url.toString();
      });
    }
  });

  // --- Delete Confirmation Buttons ---
  const deleteButtons = document.querySelectorAll('.delete-btn');
  deleteButtons.forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const id = this.getAttribute('data-id');
      const table = this.getAttribute('data-table');
      const deleteUrl = `delete.php?id=${id}&table=${table}`;

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = deleteUrl;
        }
      });
    });
  });
  //internet connection
  function checkInternetConnection() {
    if (!navigator.onLine) {
      Swal.fire({
        icon: 'warning',
        title: 'No Internet Connection',
        text: 'You need an internet connection to access this site.',
        confirmButtonColor: '#f39c12'
      });
    }
  }

  // Check when the page loads
  checkInternetConnection();

  // Also listen for changes (offline or online)
  window.addEventListener('offline', checkInternetConnection);
});