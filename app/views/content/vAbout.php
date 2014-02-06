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
                                        <?php if (isset($params)): ?>
                                        <option value="car"<?php echo selectedVal('car', $params['type']); ?>>Cars</option>
                                        <option value="boat"<?php echo selectedVal('boat', $params['type']); ?>>Boats</option>
                                        <option value="moto"<?php echo selectedVal('moto', $params['type']); ?>>Motorcycles</option>
                                        <option value="atv"<?php echo selectedVal('atv', $params['type']); ?>>ATVs</option>
                                        <option value="rv"<?php echo selectedVal('rv', $params['type']); ?>>RVs</option>
                                        <option value="trailer"<?php echo selectedVal('trailer', $params['type']); ?>>Trailers</option>
                                        <?php else: ?>
                                        <option value="car">Cars</option>
                                        <option value="boat">Boat and Yatchs</option>
                                        <option value="moto">Motorcycles</option>
                                        <option value="atv">ATVs</option>
                                        <option value="rv">RVs</option>
                                        <option value="trailer">Trailers</option>
                                        <?php endif; ?>
                                    </select>
                                </p>
                            </li>
                            <?php endif; ?>
                            <?php if ( ! Config::get('searchCountry', 'search')): ?>
                            <li>
                                <p><span>Where?</span></p>
                                <p>
                                    <select name="country" class="searchCountry">
                                        <?php if (isset($params)): ?>
                                        <option value="us"<?php echo selectedVal('us', $params['country']); ?>>United States</option>
                                        <option value="ca"<?php echo selectedVal('ca', $params['country']); ?>>Canada</option>
                                        <option value="uk"<?php echo selectedVal('uk', $params['country']); ?>>United Kingdom</option>
                                        <?php else: ?>
                                        <option value="us">United States</option>
                                        <option value="ca">Canada</option>
                                        <option value="uk">United Kingdom</option>
                                        <?php endif; ?>
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
                    <div class="staticNav">
                        <ul>
                            <li><a href="<?php echo baseURL('about_us'); ?>" class="on">About Us</a></li>
                            <li><a href="<?php echo baseURL('privacy_policy'); ?>">Privacy Policy</a></li>
                            <li><a href="<?php echo baseURL('terms_of_use'); ?>">Terms of Use</a></li>
                            <li><a href="<?php echo baseURL('contact'); ?>">Contact</a></li>
                        </ul>
                    </div>
                    <div class="staticContent">
                        <h2>What is <?php echo Config::get('siteName', 'seo'); ?>?</h2>
                        
                        <p><?php echo Config::get('siteName', 'seo'); ?> is the leading search engine for classified ads in many countries of world.</p>
                        
                        <p><?php echo Config::get('siteName', 'seo'); ?> does not host any of classified ads. <?php echo Config::get('siteName', 'seo'); ?> will help you find the most interesting ads published in thousands of classifieds websites, saving you the time it would take you to surf all those pages.</p>
                    </div>
                </div>
            </section>
            <!-- content layer end //-->