<!-- Komponent s novými uživateli -->
<aside class="followNew">
    <div class="followNewContainer">
        <h2 class="followNewTitle pink"> Noví uživatelé </h2>
        <hr class="divider">
        <?php
        // Výpis 10 náhodných uživatelů
        $sql = "select username from user order by rand() limit 10";
        $result = $con -> query($sql);
        while($row = $result -> fetch_assoc()) {
        ?>
        <div class="followProfile">
            <p class="followUsername"> <a href="./pages/profile.php?username=<?php echo$row["username"]; ?>"> <?php echo$row["username"]; ?> </a> </p>
        </div>
        <?php
        }
        ?>
    </div>
</aside>