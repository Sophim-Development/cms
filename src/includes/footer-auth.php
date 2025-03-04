<footer class="bg-gray-800 text-white p-6 mt-12">
        <div class="container mx-auto text-center">
            <p class="text-sm">© <?php echo date('Y'); ?> Hospital Management System. All rights reserved.</p>
            <p class="text-sm mt-2">Logged in as: 
                <?php 
                if (isset($_SESSION['admin_id'])) echo 'Admin';
                elseif (isset($_SESSION['doctor_id'])) echo 'Doctor';
                elseif (isset($_SESSION['user_id'])) echo 'Patient';
                ?>
            </p>
        </div>
    </footer>
</body>
</html>