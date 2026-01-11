# How to Add Pictures to Halls - Step by Step Guide

## Overview
The image upload functionality is already built into your Laravel application. Owners can upload multiple images when creating or editing halls, and these images will be displayed to customers when browsing halls.

## Step-by-Step Instructions

### For Owners: Adding Pictures When Creating a Hall

1. **Login as an Owner**
   - Go to your website and login with owner credentials
   - You'll be redirected to the Owner Dashboard

2. **Navigate to Add Hall Page**
   - Click the "Add New Hall" button on your dashboard
   - This will take you to the hall creation form

3. **Fill in Hall Information**
   - Enter the hall name, description, location, price, capacity, etc.

4. **Upload Images**
   - Scroll down to the "Photos" section
   - Click the file input field
   - Select one or multiple images from your computer
   - Supported formats: JPEG, PNG, JPG, GIF
   - Maximum file size: 2MB per image
   - You can select multiple images at once (hold Ctrl/Cmd while selecting)

5. **Submit the Form**
   - Click the "Save" button
   - The images will be automatically uploaded and stored
   - You'll be redirected back to your dashboard

### For Owners: Adding Pictures When Editing a Hall

1. **Go to Owner Dashboard**
   - Login as an owner
   - Find the hall you want to edit in the "My Halls" table

2. **Click Edit**
   - Click the "Edit" link next to the hall
   - You'll see the edit form with existing hall data

3. **Add New Images**
   - Scroll to the "Photos" section
   - Select new images to add
   - Note: Currently, the form replaces all images. To keep existing images, you may need to re-upload them along with new ones.

4. **Save Changes**
   - Click "Update Hall" to save

### Technical Details

**Where Images Are Stored:**
- Images are stored in: `storage/app/public/places/`
- The system creates a symbolic link from `public/storage` to `storage/app/public`
- This link allows images to be accessible via the web browser

**How Images Are Saved:**
- Images are stored with unique filenames
- Multiple images are saved as a JSON array in the database
- The first image is used as the main/thumbnail image

**Image Display:**
- **Customer Hall List Page**: Shows the first image as a thumbnail
- **Hall Details Page**: Shows all images in a gallery
- **Reservation Confirmation**: Shows the main image

### Troubleshooting

**If images don't appear:**
1. Make sure the storage link exists:
   ```bash
   php artisan storage:link
   ```
   (This has already been done for you)

2. Check file permissions:
   - Ensure `storage/app/public/places` directory is writable
   - On Windows, this should work automatically
   - On Linux/Mac, you may need: `chmod -R 775 storage`

3. Check image format:
   - Only JPEG, PNG, JPG, GIF are supported
   - Make sure file size is under 2MB

4. Clear cache (if needed):
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

**If you see a placeholder image:**
- This means no images were uploaded for that hall
- The system shows `images/placeholder-hall.jpg` as a fallback
- You can add a custom placeholder image in `public/images/placeholder-hall.jpg`

### Best Practices

1. **Image Quality**: Use high-quality images (but keep file size under 2MB)
2. **Multiple Angles**: Upload multiple images showing different angles of the hall
3. **Consistent Sizing**: Try to use images with similar dimensions for better display
4. **File Naming**: The system handles file naming automatically, so you don't need to worry about it

### Code Locations (For Developers)

- **Image Upload Handler**: `app/Http/Controllers/OwnerController.php` (lines 72-79)
- **Image Display (List)**: `resources/views/customer/places/index.blade.php` (lines 20-26)
- **Image Display (Details)**: `resources/views/customer/places/show.blade.php` (lines 12-28)
- **Image Upload Form**: `resources/views/owner/places/create.blade.php` (lines 63-67)

## Summary

The image upload feature is fully functional! Owners simply need to:
1. Go to "Add New Hall"
2. Fill in the form
3. Select images in the "Photos" section
4. Click Save

Images will automatically appear on customer-facing pages when they browse halls.

