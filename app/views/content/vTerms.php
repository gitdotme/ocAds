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
                    <form method="get" action="<?php echo baseURL(Route::get_config('searchLink', 'route')); ?>" class="searchForm">
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
                                        <option value="boat">Boat and Yachts</option>
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
                                        <option value="au">Australia</option>
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
                    <h1>Terms of Use</h1>
                    <?php echo $sidebarLayout; ?>
                    <div class="staticContent">
                        <h2>PLEASE READ THESE TERMS OF USE CAREFULLY, AS THEY CONTAIN IMPORTANT INFORMATION REGARDING YOUR LEGAL RIGHTS AND REMEDIES.</h2>
                        
                        <div class="clear">&nbsp;</div>
                        
                        <p>Welcome to our website. If you continue to browse and use this website you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our <a href="<?php echo baseURL('privacy_policy'); ?>">privacy policy</a> govern <?php echo Config::get('siteName', 'seo'); ?>&rsquo;s relationship with you in relation to this website.</p>

                        <p>The term &ldquo;<?php echo Config::get('siteName', 'seo'); ?>&rdquo; or &ldquo;us&rdquo; or &ldquo;we&rdquo; refers to the owner of the website. The term &ldquo;you&rdquo; refers to the user or viewer of our website.</p>

                        <p>The use of this website is subject to the following terms of use:</p>

                        <ul>
                                <li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>
                                <li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>
                                <li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>
                                <li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>
                                <li>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.</li>
                                <li>Unauthorised use of this website may give to a claim for damages and/or be a criminal offence.</li>
                                <li>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>
                                <li>You may not create a link to this website from another website or document without <?php echo Config::get('siteName', 'seo'); ?>&rsquo;s prior written consent.</li>
                        </ul>

                    </div>
                </div>
            </section>
            <!-- content layer end //-->