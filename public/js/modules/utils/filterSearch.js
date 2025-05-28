const $ = (selector) => document.querySelector(selector);
const $$ = (selector) => document.querySelectorAll(selector);

const filterSearch = $("#filter-search");
const tableData = $("#table-data");

filterSearch.addEventListener("keyup", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const rows = tableData.querySelectorAll("tr");

    rows.forEach((row) => {
        const cells = row.querySelectorAll("td");
        let rowContainsSearchTerm = false;

        cells.forEach((cell) => {
            if (cell.textContent.toLowerCase().includes(searchTerm)) {
                rowContainsSearchTerm = true;
            }
        });

        if (rowContainsSearchTerm) {
            row.style.display = "";
            scrollTo({
                top: row.offsetTop - 100,
                behavior: "smooth",
            });
        } else {
            row.style.display = "none";
        }
    });
});
