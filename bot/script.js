const puppeteer = require('puppeteer');
const axios = require('axios');

(async () => {
    // Fetch domain names from the API
    const response = await axios.get('http://localhost:8000/api/get-domains.php');
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
        // Navigate to the website
        await page.goto('https://trustpositif.komdigi.go.id/');

        // Click the input field for domain submission
        await page.waitForSelector('input[type="text"]'); // Adjusted selector
        await page.click('input[type="text"]');

        // Click the textarea for domain input
        await page.waitForSelector('textarea'); // Adjusted selector
        await page.click('textarea');

        // Input the domains (join them with new lines)
        await page.type('/html/body/div[3]/div/div/div[2]/div/div[1]/form/div/textarea', group.join('\n'));

        // Submit the form (you may need to click a submit button here)
        // await page.click('selector-for-submit-button');

        // Wait for the results to load
        await page.waitForTimeout(5000); // Adjust as necessary

        // Check the output status
        const status = await page.evaluate(() => {
            return document.querySelector('/html/body/div[2]/div[5]/div[2]/table/tbody/tr/td[2]').innerText;
        });

        // Update the database based on the status
        const updateStatus = status === 'ada' ? 'nawala' : 'aman';
        for (const domain of group) {
            await axios.post('http://localhost/path/to/api/update-domain-status.php', {
                domain_name: domain,
                status: updateStatus
            });
        }
    }

    // Close the browser
    await browser.close();
})();
