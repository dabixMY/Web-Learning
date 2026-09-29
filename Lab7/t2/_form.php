<div id="contentWrapper" class="content">
    <form id="contactForm" method="post">
        <label for="Sal">Salutation: </label>
        <select id="Sal" name="salutation">
            <option disabled selected value> -- Select a Salutation -- </option>
            <option value="Mr" <?= (isset($salutation) && $salutation == 'Mr') ? 'selected' : ''; ?>>Mr</option>
            <option value="Ms" <?= (isset($salutation) && $salutation == 'Ms') ? 'selected' : ''; ?>>Ms</option>
            <option value="Mrs" <?= (isset($salutation) && $salutation == 'Mrs') ? 'selected' : ''; ?>>Mrs</option>
            <option value="Mdm" <?= (isset($salutation) && $salutation == 'Mdm') ? 'selected' : ''; ?>>Mdm</option>
        </select>
        <div id="salutationError" class="error"><?= $errors['salutation'] ?? ''; ?></div>
        
        <label for="nam">Name: </label>
        <input type="text" id="nam" name="name" value="<?= htmlspecialchars($name); ?>">
        <div id="nameError" class="error"><?= $errors['name'] ?? ''; ?></div>
        
        <label for="email">E-mail: </label>
        <input type="text" id="email" name="email" value="<?= htmlspecialchars($email); ?>">
        <div id="emailError" class="error"><?= $errors['email'] ?? ''; ?></div>

        <label for="phone">Phone Number: </label>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($phone); ?>">
        <div id="phoneError" class="error"><?= $errors['phone'] ?? ''; ?></div>

        Type of Enquiry:<br>
        <input type="checkbox" name="enquiry[]" value="General Enquiry" <?= in_array('General Enquiry', $enquiry) ? 'checked' : ''; ?>> General Enquiry
        <input type="checkbox" name="enquiry[]" value="Complaints" <?= in_array('Complaints', $enquiry) ? 'checked' : ''; ?>> Complaints
        <input type="checkbox" name="enquiry[]" value="Suggestions" <?= in_array('Suggestions', $enquiry) ? 'checked' : ''; ?>> Suggestions
        <div id="enquiryError" class="error"><?= $errors['enquiry'] ?? ''; ?></div>

        <label for="message">Subject:</label><br>
        <textarea id="message" name="message" rows="10" cols="30"><?= htmlspecialchars($message); ?></textarea>
        <div id="messageError" class="error"><?= $errors['message'] ?? ''; ?></div>
    
        <input type="submit" value="Send">
    </form>
</div>
