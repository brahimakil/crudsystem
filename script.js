document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const searchResults = document.getElementById('searchResults');
    const searchBy = document.querySelector('input[name="searchBy"]:checked');

    searchInput.addEventListener('input', () => {
        const searchValue = searchInput.value.trim(); // Trim whitespace from search input
        const searchByValue = searchBy ? searchBy.value : 'title' && 'category'; ;

        if (searchValue === '') {
            searchResults.innerHTML = ''; // Clear search results if search input is empty
            return;
        }

        fetch(`search.php?search=${searchValue}&searchBy=${searchByValue}`)
            .then(response => response.text())
            .then(data => {
                searchResults.innerHTML = `
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Taxes</th>
                                <th>Ads</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Category</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>${data}</tbody>
                    </table>`;
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    });
});
