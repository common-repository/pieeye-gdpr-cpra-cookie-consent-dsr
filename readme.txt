=== Pieeye: GDPR+CPRA+Cookie Consent+DSR ===
Tags: cookies, cookie banner, DSR, GDPR, CPRA, user consent, cookie policy, privacy compliance, data privacy
Tested up to: 6.2
Stable tag: 1.0.0
Contributors: pieeye
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
PieEye simplifies GDPR/CPRA compliance with Cookie Consent and Data Subject Request Management. The Cookie Manager lets you customise the Cookie Banner and control which cookies are deployed. Consent events provide real-time updates on user preferences. IN ADDITION, the PieEye App automates the DSR process, creating a portal for shoppers to submit a DSR, verified identity, connects to any data sources in addition to Wordpress (like WooCommerce), and gives quick responses to customers within the required time frame. All of it automated.

== Features ==

= Cookie Consent: =
PieEye is a consent management platform that helps businesses achieve compliance with data privacy regulations without worrying about complex legal jargon or technical expertise. With more Data Privacy laws, Cookie Compliance is more important than ever. Our cutting-edge Cookie Banner makes website fully compliant with all regulations, safeguarding your customers' data rights and protecting you.

**Cookie Consent Management:** PieEye's Consent Management helps businesses achieve compliance with GDPR and CCPA/CPRA regulations through customizable cookie consent banners. 

**Consent Notices and Preferences Management:** PieEye allows businesses to effortlessly create and manage consent notices and preferences for their visitors. This ensures full transparency and control over their data, and helps build trust and loyalty.

**Centralized Privacy Center:** PieEye's centralized Privacy Center empowers visitors to manage their privacy preferences and access relevant information about data collection and processing, thereby providing data collection transparency.

**Seamless Integration:** PieEye's Consent Management seamlessly integrates with popular platforms like WordPress, Shopify, and Hubspot, streamlining compliance efforts and saving time.

**Affordable and Flexible Pricing:** PieEye offers flexible pricing options that fit your budget, including a free plan for small businesses.

**Website Audit:** PieEye helps businesses detect all first- and third-party cookies, tags, trackers, and more, thereby providing a comprehensive website audit.

**Banner Customization:** PieEye offers ready templates for branding and allows businesses to apply the latest changes to global laws and frameworks to their consent banners.

**Simplify Deployment:** PieEye provides integrations and plugins for widely used Content Management Systems (CMS) and other systems, making it easier to deploy cookie banners. 

= Data Subject Request (DSR): =
PieEye is a privacy compliance platform designed for eCommerce businesses. The software simplifies the complexities of data privacy and helps businesses comply with privacy laws such as CPRA and GDPR.

**Manage Data Subject Requests Easily:** PieEye makes it easy to verify a data subject's identity, assign inbound requests to the appropriate owner, automate retrieval from any data source or vendor, and deliver results to the data subjects on time.

**Automate Workflow:** Automate DSR workflow across your whole Data Ecosystem, from your internal data sources to external vendors. Assign roles and embed your DSR form for compliance with laws granting data subjects the right to delete, modify, or request the data that your company may store about that person.

**Meet Deadlines:** PieEye helps you meet the strict deadlines for notifications and remediation specified by law.

**Keep an Audit Trail:** Minimize legal and financial exposure by keeping an audit trail of data requests and responses.

**React Quickly:** Respond quickly to data subject requests to comply with laws and maintain customer trust.

Automate the entire DSR workflow, from data retrieval to delivering results to data subjects on time.

Keep an audit trail of all data requests and responses to minimize legal and financial exposure.

React quickly to data subject requests and maintain customer trust.

== 3rd Party Applications: ==

* We are using https://pii.ai which is our own application to manage user and domain information and configurations.
* The https://app.pii.ai is used for redirecting user to our Dashboard where they can configure their banner settings, cookie settings and DSR configurations
* The https://wordpress.pii.ai is used  to interact with our app specific for wordpress plugin, to get cookie data and banner configurations to inject in wordpress site.
* Our Privacy Policy Link: https://pii.ai/privacy-notice/
* The PieEye WordPress plugin allows users (website owners) to first register and sign up with the PieEye platform. It enables website owners to honor data subject requests and cookie management and takes user preferences for the cookies present on their website for their consumers. The plugin strictly adheres to privacy regulations and doesn't collect any user data without consent. Further, it doesn't utilize any tracking services or GA to monitor wp-admin usage. During user sign-ups; we redirect users to our platform registration screen where we register the users. Only domain and URL is taken in order to register the users with us via function. 

**The plugin features communication via platform services via APIs as follows:**

* /site-exists: To check if a site already exists in our system, and load the dashboard accordingly based on the API response.
* /script: To verify the availability of the banner script for a website.
* /deactivate: To perform necessary changes in our system during plugin deactivation.
* /uninstall: To implement changes in our system upon plugin uninstallation.
* /statistics: To display statistical data related to our app.

== Privacy Notice: ==

This plugin interacts with our application for enhanced functionality. To achieve this, we utilize your domain name as a means of communication. By activating this plugin, you are consenting to the use of your domain name for these specific purposes.

**What Data is Collected?**
The only piece of information we access and utilize is your domain name. We do not collect any other personally identifiable information (PII) through this plugin.

**How is Your Data Used?**
Your domain name is exclusively used to facilitate communication between your WordPress site and our application. It helps us provide you with the services and features offered by this plugin. Your data is not used for marketing purposes or shared with third parties.

**Data Protection**
We take your privacy seriously. All data transmission and storage are handled with the utmost care and security. We employ industry-standard security measures to safeguard your domain name and ensure it is used solely for the intended purposes.

**Your Rights**
You have the right to deactivate this plugin at any time if you no longer wish to share your domain name. Deactivation will cease any further interaction between your site and our application.

**Questions or Concerns**
If you have any questions or concerns about how your domain name is used or any other privacy-related matters, please refer to our detailed privacy policy, which can be found at [Privacy Policy](https://pii.ai/privacy-notice/), or contact our support team at [support email](mailto:support@pii.ai).
Your privacy is important to us, and we are committed to transparency and the responsible use of your data. Thank you for choosing our plugin.

== Screenshots ==

1. Cookie Overview: Cookie dashboard overview.
2. Domains: Add and Manage website domain.
3. Cookies: Displays, manages cookie details.
4. Cookie Settings: Customize application preferences and options.
5. Cookie Banner: Cookie consent banner on the user-end.
6. DSR Dashboard: View and manage all DSRs and their tasks.
7. DSR Portal: Create and manage your DSR form with the necessary request types.

== Changelog ==
= 1.0.0  =
* Initial release of plugin, with features such as cookie banner, user consent, Automated DSR request