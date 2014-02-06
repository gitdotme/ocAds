<!-- home header layer begin //-->
            <header id="homeHeader">
                <!-- header logo begin //-->
                <div class="headerLogo">
                    <p><a href="<?php echo baseURL(); ?>" title="<?php echo Config::get('siteName', 'seo'); ?>"><img src="<?php echo baseURL('assets/img/logo-large.gif'); ?>" alt="<?php echo Config::get('siteName', 'seo'); ?>"></a></p>
                </div>
                <!-- header logo end //-->
                <!-- header bar begin //-->
                <div class="headerBar">
                    <!-- search form begin //-->
                    <form method="get" action="<?php echo baseURL(Config::get('searchLink', 'seo')); ?>" class="searchForm">
                        <ul>
                            <li>
                                <p><span>What?</span></p>
                                <p><input type="text" name="query" class="searchQuery" placeholder="Search for..."></p>
                            </li>
                            <?php if ( ! Config::get('searchType', 'search')): ?>
                            <li>
                                <p><span>Which?</span></p>
                                <p>
                                    <select name="type" class="searchType">
                                        <option value="car">Cars</option>
                                        <option value="boat">Boat and Yatchs</option>
                                        <option value="moto">Motorcycles</option>
                                        <option value="atv">ATVs</option>
                                        <option value="rv">RVs</option>
                                        <option value="trailer">Trailers</option>
                                    </select>
                                </p>
                            </li>
                            <?php endif; ?>
                            <?php if ( ! Config::get('searchCountry', 'search')): ?>
                            <li>
                                <p><span>Where?</span></p>
                                <p>
                                    <select name="country" class="searchCountry">
                                        <option value="us">United States</option>
                                        <option value="ca">Canada</option>
                                        <option value="uk">United Kingdom</option>
                                    </select>
                                </p>
                            </li>
                            <?php endif; ?>
                            <li>
                                <p><span>&nbsp;</span></p>
                                <p><input type="submit" value="Search" class="searchButton"></p>
                            </li>
                        </ul>
                    </form>
                    <!-- search form end //-->
                </div>
                <!-- header bar end //-->
            </header>
            <!-- home header layer end //-->
            <!-- content layer start //-->
            <section id="content">
                <div class="static">
                    <h1>Privacy Policy</h1>
                    <div class="staticNav">
                        <ul>
                            <li><a href="<?php echo baseURL('about_us'); ?>">About Us</a></li>
                            <li><a href="<?php echo baseURL('privacy_policy'); ?>" class="on">Privacy Policy</a></li>
                            <li><a href="<?php echo baseURL('terms_of_use'); ?>">Terms of Use</a></li>
                            <li><a href="<?php echo baseURL('contact'); ?>">Contact</a></li>
                        </ul>
                    </div>
                    <div class="staticContent">
                        <h2>What information do we collect?</h2>

                        <p>We collect information from you when you respond to a survey or fill out a form. In those cases you may be asked to enter your name or e-mail address. You may, however, visit our site anonymously.</p>

                        <p>Google, as a third party vendor, uses cookies to serve ads on our site. Google&#39;s use of the DART cookie enables it to serve ads to our users based on their visits to our sites and other sites on the Internet. Users may opt out of the use of the DART cookie by visiting the Google ad and content network privacy policy.</p>

                        <p>Our servers may collect some of your personal information such as IP addresses and destination URLs, in order to analyze site behavior and resolve potential technical and other issues.</p>

                        <div class="clear">&nbsp;</div>
                        
                        <h2>What do we use your information for?</h2>

                        <p>Any of the information we collect from you may be used in the following ways:</p>

                        <ul>
                                <li><strong>To personalize your experience</strong> (your information helps us to better respond to your individual needs)</li>
                                <li><strong>To improve our website</strong> (we continually strive to improve what we offer on our website based on the information and feedback we receive from you)</li>
                                <li><strong>To process transactions</strong>. Your information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of delivering the purchased product or service requested.</li>
                                <li><strong>To utilize proper technical maintenance of the site</strong>.</li>
                                <li><strong>To provide new and improved services on the site.</strong>.</li>
                        </ul>
                        
                        <div class="clear">&nbsp;</div>

                        <h2>How do we protect your information?</h2>

                        <p>We implement a variety of security measures to maintain the safety of your personal information.</p>
                        
                        <div class="clear">&nbsp;</div>

                        <h2>Do we use cookies?</h2>

                        <p>Yes. Cookies are small files that a site or its service provider transfers to your computer&#39;s hard drive through your Web browser (if you allow it) that enables the sites or service providers systems to recognize your browser and capture and remember certain information.</p>

                        <p>We use cookies to understand and save your preferences for future visits and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future.</p>

                        <div class="clear">&nbsp;</div>
                        
                        <h2>Do we disclose any information to outside parties?</h2>

                        <p>We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information. This does not include trusted third parties who assist us in operating our website, conducting our business, or servicing you, so long as those parties agree to keep this information confidential. We may also release your information when we believe release is appropriate to comply with the law, enforce our site policies, or protect our rights, property, or safety, or those of others. However, non-personally identifiable visitor information may be provided to other parties for marketing, advertising, or other uses.</p>

                        <div class="clear">&nbsp;</div>
                        
                        <h2>Third party links</h2>

                        <p>Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>

                        <div class="clear">&nbsp;</div>
                        
                        <h2>Changes to our Privacy Policy</h2>

                        <p>If we decide to change our privacy policy, we will post those changes on this page.</p>

                        <div class="clear">&nbsp;</div>
                        
                        <h2>Contacting Us</h2>

                        <p>If you have any questions regarding this privacy policy, you may <a href="<?php echo baseURL('contact_us'); ?>">contact us here</a>.</p>
                    </div>
                </div>
            </section>
            <!-- content layer end //-->