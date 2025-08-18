const puppeteer = require('puppeteer');
const axios = require('axios');

(async () => {
    // Fetch domain names from the API
    const response = await axios.get('http://localhost:8000/api/get-domains.php'); // Ensure this path is correct
    const domains = response.data.data;

    // Group domains into batches of 5
    const groupedDomains = [];
    for (let i = 0; i < domains.length; i += 5) {
        groupedDomains.push(domains.slice(i, i + 5));
    }

    // Launch Puppeteer
    const browser = await puppeteer.launch();
    const page = await browser.newPage();

    for (const group of groupedDomains) {
        console.log(`Processing group: ${group.join(', ')}`);
        
        // Navigate to the website
        await page.goto('https://trustpositif.komdigi.go.id/');

        // Wait for page to load
        await page.waitForSelector('input[type="text"]'); // Wait for the input field to load

        // Find and click the input field
        await page.click('input[type="text"]');

        // Find and click the textarea
        await page.waitForSelector('textarea');
        await page.click('textarea');

        // Clear and input the domains
        await page.evaluate(() => {
            document.querySelector('textarea').value = '';
        });
        await page.type('textarea', group.join('\n'));

        // Find and click the submit button (adjust selector as needed)
        await page.waitForSelector('button[type="submit"], input[type="submit"], .btn-primary');
        await page.click('button[type="submit"], input[type="submit"], .btn-primary');

        // Wait for the results to load
        await page.waitForSelector('table tbody tr'); // Wait for the results table to load

        // Check the output status
        const results = await page.evaluate(() => {
            const rows = document.querySelectorAll('table tbody tr');
            const statuses = [];
            rows.forEach(row => {
                const domain = row.querySelector('td:nth-child(1)')?.innerText;
                const status = row.querySelector('td:nth-child(2)')?.innerText;
                if (domain && status) {
                    statuses.push({ domain, status });
                }
            });
            return statuses;
        });

    // Update the database based on the results and show toast notifications for Nawala domains

        for (const result of results) {
            const updateStatus = result.status.toLowerCase().includes('tidak ada') ? 'Aman' : 'Nawala';
            await axios.post('http://localhost:8000/api/update-domain-status.php', {
                domain_name: result.domain,
                status: updateStatus
            });
            console.log(`Updated ${result.domain} status to ${updateStatus}`);
        }

        // Wait before processing next group
        await new Promise(resolve => setTimeout(resolve, 2000)); // Use setTimeout instead of waitForTimeout
    }

    // Close the browser
    await browser.close();
})();
