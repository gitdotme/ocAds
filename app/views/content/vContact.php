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
                    <h1>Contact</h1>
                    <?php echo $sidebarLayout; ?>
                    <div class="staticContent">
                        <div class="contact">
                            <?php if (isset($success) AND $success === TRUE): ?>
                                <div class="success">
                                    <p><?php echo $result; ?></p>
                                </div>
                            <?php elseif (isset($success) AND $success === FALSE): ?>
                                <div class="error">
                                    <?php echo $result; ?>
                                </div>
                            <?php endif; ?>
                            <form method="post" action="<?php echo baseURL('contact'); ?>">
                                <div class="formPart">
                                    <label for="fName">Your name</label>
                                    <input type="text" name="name" id="fName" value="<?php echo filterText(Input::post('name')); ?>" class="inputText">
                                </div>
                                <div class="formPart">
                                    <label for="fEmail">Your email</label>
                                    <input type="text" name="email" id="fEmail" value="<?php echo filterText(Input::post('email')); ?>" class="inputText">
                                </div>
                                <div class="formPart">
                                    <label for="fMessage">Your message</label>
                                    <textarea name="message" id="fMessage" class="inputTextArea"><?php echo filterText(Input::post('message')); ?></textarea>
                                </div>
                                <div class="formPart">
                                    <label for="fCaptcha">Captcha</label>
                                    <img src="<?php echo baseURL('captcha'); ?>" alt="Captcha"> &nbsp; <input type="text" name="captcha" id="fCaptcha" value="" class="inputCaptcha">
                                </div>
                                <div class="formPart">
                                    <button class="inputSubmit">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- content layer end //-->