<div class="leftAboutCol large-30">
    <nav class="ink-navigation">
        <ul class="menu-about">
            <li <?php echo $active == "overview" ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=overview">Overiew</a></li>
            <li <?php echo $active == 'education' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=education">Work and Education</a></li>
            <li <?php echo $active == 'living' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=living">Places You've Lived</a></li>
            <li <?php echo $active == 'contact' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=contact">Contact and Basic Info</a></li>
            <li <?php echo $active == 'relationship' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=relationship">Family and Relationships</a></li>
            <li <?php echo $active == 'bio' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=bio">Details About You</a></li>
            <li <?php echo $active == 'overviews' ? 'class="active"' : '' ?>><a href="/about?user=<?php echo $user->data->username ?>&section=year-overviews">Life Events</a></li>
        </ul>
    </nav>
</div>