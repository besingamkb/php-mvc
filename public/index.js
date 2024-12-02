"use strict";

document.addEventListener("DOMContentLoaded", () => {
    const apiUrl = "/searchAuthor";
    const tableBody = document.querySelector("table tbody");
    const paginationContainer = document.querySelector("nav ul");
    const searchInput = document.getElementById("default-search");
    const pageInfoContainer = document.getElementById("page-info");

    let currentQuery = "";
    let currentPage = 1;
    let totalPages = 1;
    let totalResults = 0;

    // display page info
    function updatePageInfo() {
        if (pageInfoContainer) {
            pageInfoContainer.textContent = `Page ${currentPage} of ${totalPages} | Total ${totalResults} results`;
        }
    }

    //update table with data
    function updateTable(data) {
        tableBody.innerHTML = "";

        if (data.length === 0) {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        No data found.
                    </td>
                </tr>
            `;
            return;
        }

        data.forEach(item => {
            const row = document.createElement("tr");
            row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700";
            row.innerHTML = `
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    ${item.title}
                </th>
                <td class="px-6 py-4">
                    ${item.name}
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    // update pagination
    function updatePagination() {
        paginationContainer.innerHTML = "";

        // Previous
        const prevLi = document.createElement("li");
        prevLi.innerHTML = `
            <a href="#" class="flex items-center justify-center px-4 h-10 text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${
            currentPage === 1 ? "pointer-events-none opacity-50" : ""
        }">Previous</a>
        `;
        prevLi.addEventListener("click", () => {
            console.log("prev current page is", currentPage);
            if (currentPage > 1) {
                currentPage -= 1;
                fetchData(currentQuery, currentPage);
            }
        });
        paginationContainer.appendChild(prevLi);

        // Next button
        const nextLi = document.createElement("li");
        nextLi.innerHTML = `
            <a href="#" class="flex items-center justify-center px-4 h-10 text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white ${
            currentPage === totalPages ? "pointer-events-none opacity-50" : ""
        }">Next</a>
        `;
        nextLi.addEventListener("click", () => {
            console.log("im at next and current page is", currentPage);
            if (currentPage < totalPages) {
                currentPage += 1;
                fetchData(currentQuery, currentPage);
            }
        });
        paginationContainer.appendChild(nextLi);
    }

    // http request to api
    async function fetchData(query = "", page = 1) {
        try {
            const url = `${apiUrl}?search=${encodeURIComponent(query)}&page=${page}`;
            console.log("url is", url);
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const jsonResponse = await response.json();
            console.log("json response is", jsonResponse.data);

            if (jsonResponse.status !== "success" || !jsonResponse.data) {
                throw new Error("whoops! something went wrongs.");
            }
            currentPage = page;
            totalPages = parseInt(jsonResponse.pagination.total_pages, 10);
            totalResults = parseInt(jsonResponse.pagination.total, 10);
            updateTable(jsonResponse.data);
            updatePagination();
            updatePageInfo();
        } catch (error) {
            console.error("Error fetching data:", error);
            tableBody.innerHTML = `
                <tr>
                    <td colspan="2" class="px-6 py-4 text-center text-red-500">
                        Failed to load data.
                    </td>
                </tr>
            `;
            paginationContainer.innerHTML = "";
        }
    }

    searchInput.addEventListener("input", () => {
        currentQuery = searchInput.value.trim();
        currentPage = 1;
        fetchData(currentQuery, currentPage);
    });

    fetchData();
});
