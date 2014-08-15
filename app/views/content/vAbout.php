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
                    <h1>About Us</h1>
                    <?php echo $sidebarLayout; ?>
                    <div class="staticContent">
                        <h2>What is <?php echo Config::get('siteName', 'seo'); ?>?</h2>
                        
                        <p><?php echo Config::get('siteName', 'seo'); ?> is the leading search engine for classified ads in many countries of world.</p>
                        
                        <p><?php echo Config::get('siteName', 'seo'); ?> does not host any of classified ads. <?php echo Config::get('siteName', 'seo'); ?> will help you find the most interesting ads published in thousands of classifieds websites, saving you the time it would take you to surf all those pages.</p>
                    </div>
                </div>
            </section>
            <!-- content layer end //-->