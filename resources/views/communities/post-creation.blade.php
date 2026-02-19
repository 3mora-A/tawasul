
                  

       <form 
       method="POST"
       action="{{ route('communities.posts.store', $community->id) }}"
       enctype="multipart/form-data"
       class="mb-6   rounded-lg "
   >
            @csrf
        
        <div  id="status" class="status box status-box" >


            <div class="status-menu">
                <a id="tab-status" class="status-menu-item active" href="#" onclick="showStatusTab()">Status</a>
                <a id="tab-photos" class="status-menu-item" href="#"onclick="showPhotosTab()">Photos / Videos</a>
            </div>
        
        
            <div class="status-main" >
                <textarea 
                name="content" 
                class="status-textarea bg-gray-700 border" 
                placeholder="What's on your mind, {{ Auth::user()->username }}" 
                required></textarea>

            </div>
        
                              
            <div class="status-actions">
                <div class="status-action-group">
                  <a href="#" class="status-action">
                    <!-- People Icon -->
                    <svg viewBox="-42 0 512 512" xmlns="http://www.w3.org/2000/svg">
                  <path d="M333.7 123.3c0 33.9-12.2 63.2-36.2 87.2-24 24-53.3 36.1-87.1 36.1h-.1c-33.9 0-63.2-12.1-87.1-36.1-24-24-36.2-53.3-36.2-87.2 0-33.9 12.2-63.2 36.2-87.2 24-24 53.2-36 87-36.1h.2c33.8 0 63.2 12.2 87.1 36.1 24 24 36.2 53.3 36.2 87.2z" fill="#ffbb85"/>
                  <path d="M427.2 424c0 26.7-8.5 48.3-25.3 64.3-16.5 15.7-38.4 23.7-65 23.7H90.2c-26.6 0-48.5-8-65-23.7C8.5 472.3 0 450.7 0 423.9c0-10.2.3-20.4 1-30.2a302.7 302.7 0 0112.1-64.9c3.3-10.3 7.8-20.5 13.4-30.3 5.8-10.2 12.5-19 20.1-26.3a89 89 0 0129-18.2c11.2-4.4 23.7-6.7 37-6.7 5.2 0 10.3 2.2 20 8.5l21 13.5c6.6 4.3 15.7 8.3 27 11.9a107.7 107.7 0 0033 5.3c11 0 22-1.8 33-5.3 11.2-3.6 20.3-7.6 27-12l21-13.4c9.7-6.3 14.7-8.5 20-8.5 13.3 0 25.7 2.3 37 6.7a89 89 0 0128.9 18.2c7.6 7.3 14.4 16.1 20.2 26.3 5.5 9.8 10 20 13.3 30.3a305.5 305.5 0 0112.1 64.9c.7 9.8 1 20 1 30.2z" fill="#6aa9ff"/>
                  </svg>
                  People
              </a>
              <a href="#" class="status-action">
                  <!-- Check In Icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <path d="M87.084 192c-.456-5.272-.688-10.6-.688-16C86.404 78.8 162.34 0 256.004 0s169.6 78.8 169.6 176c0 5.392-.232 10.728-.688 16h.688c0 96.184-169.6 320-169.6 320s-169.6-223.288-169.6-320h.68zm168.92 32c36.392 1.024 66.744-27.608 67.84-64-1.096-36.392-31.448-65.024-67.84-64-36.392-1.024-66.744 27.608-67.84 64 1.096 36.392 31.448 65.024 67.84 64z" fill="#e21b1b"/>
                  </svg>
                  Check in
              </a>
              <a href="#" class="status-action">
                  <!-- Mood Icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                  <circle cx="256" cy="256" r="256" fill="#ffca28"/>
                  <g fill="#6d4c41">
                      <path d="M399.68 208.32c-8.832 0-16-7.168-16-16 0-17.632-14.336-32-32-32s-32 14.368-32 32c0 8.832-7.168 16-16 16s-16-7.168-16-16c0-35.296 28.704-64 64-64s64 28.704 64 64c0 8.864-7.168 16-16 16zM207.68 208.32c-8.832 0-16-7.168-16-16 0-17.632-14.368-32-32-32s-32 14.368-32 32c0 8.832-7.168 16-16 16s-16-7.168-16-16c0-35.296 28.704-64 64-64s64 28.704 64 64c0 8.864-7.168 16-16 16z"/>
                  </g>
                  <path d="M437.696 294.688c-3.04-4-7.744-6.368-12.736-6.368H86.4c-5.024 0-9.728 2.336-12.736 6.336-3.072 4.032-4.032 9.184-2.688 14.016C94.112 390.88 170.08 448.32 255.648 448.32s161.536-57.44 184.672-139.648c1.376-4.832.416-9.984-2.624-13.984z" fill="#fafafa"/>
                  </svg>
                  Mood
              </a>
            </div>
            <button class="share-btn">
                Share
              </button>                   
               </div>
          </div>

    </form>
        <br>

        <form 
        method="POST"
        action="{{ route('communities.posts.store', $community->id) }}"
        enctype="multipart/form-data"
        class="mb-6 rounded-lg "
    >
            @csrf
        
        <div id="choice" class="status box choice-class" style="display: none;">
            <div class="status-menu">
                <a id="tab-status" class="status-menu-item" href="#" onclick="showStatusTab()">Status</a>
                <a id="tab-photos" class="status-menu-item active" href="#"onclick="showPhotosTab()">Photos / Videos</a>
            </div>
        
            <div class="status-main">
            
                <div class="text-add">
                    <textarea 
                    name="content" 
                    class="status-textarea bg-gray-700 border" 
                    placeholder="What's on your mind, {{ Auth::user()->username }}" 
                    required></textarea>   
                                        
                    <div class="add-photos" onclick="document.getElementById('media-upload').click();" style="cursor: pointer;">
                    <div id="inputInfo" class="upload-container">
                        <!-- Default text shown initially -->
                        <span id="upload-text">Drag and Drop or upload media</span>
                    
                        <!-- File name preview shown only after selection -->
                        <div id="media-preview" style="display: none;"></div>
                    
                        <!-- Hidden file input -->
                        <input 
                        type="file" 
                        name="media" 
                        id="media-upload" 
                        accept="image/*,video/*" 
                        style="display: none;"
                        />
                    
                        <!-- Upload icon -->
                        <span class="icon-wrap">
                        <svg fill="currentColor" height="16" viewBox="0 0 20 20" width="16" xmlns="http://www.w3.org/2000/svg">
                            <path d="m10.513 5.63 3.929 3.928-.884.884-2.933-2.933V19h-1.25V7.51l-2.933 2.932-.884-.884L9.67 5.446l.589-.029.254.212Zm5.859-1.482A6.876 6.876 0 0 0 10 0a6.876 6.876 0 0 0-6.372 4.148A4.639 4.639 0 0 0 0 8.625a4.716 4.716 0 0 0 4.792 4.625V12A3.465 3.465 0 0 1 1.25 8.625 3.412 3.412 0 0 1 4.189 5.31l.364-.06.123-.35A5.607 5.607 0 0 1 10 1.25a5.607 5.607 0 0 1 5.324 3.65l.123.348.364.06a3.412 3.412 0 0 1 2.939 3.317A3.465 3.465 0 0 1 15.208 12v1.25A4.716 4.716 0 0 0 20 8.625a4.639 4.639 0 0 0-3.628-4.477Z"></path>
                        </svg>
                        </span>
                    </div>
                    </div>
                    

                    
                
                    
                    
                
                </div>
            </div>
            
            
        
            <div class="status-actions">
            <a href="#" class="status-action">
                <!-- People Icon -->
                <svg viewBox="-42 0 512 512" xmlns="http://www.w3.org/2000/svg">
                <path d="M333.7 123.3c0 33.9-12.2 63.2-36.2 87.2-24 24-53.3 36.1-87.1 36.1h-.1c-33.9 0-63.2-12.1-87.1-36.1-24-24-36.2-53.3-36.2-87.2 0-33.9 12.2-63.2 36.2-87.2 24-24 53.2-36 87-36.1h.2c33.8 0 63.2 12.2 87.1 36.1 24 24 36.2 53.3 36.2 87.2z" fill="#ffbb85"/>
                <path d="M427.2 424c0 26.7-8.5 48.3-25.3 64.3-16.5 15.7-38.4 23.7-65 23.7H90.2c-26.6 0-48.5-8-65-23.7C8.5 472.3 0 450.7 0 423.9c0-10.2.3-20.4 1-30.2a302.7 302.7 0 0112.1-64.9c3.3-10.3 7.8-20.5 13.4-30.3 5.8-10.2 12.5-19 20.1-26.3a89 89 0 0129-18.2c11.2-4.4 23.7-6.7 37-6.7 5.2 0 10.3 2.2 20 8.5l21 13.5c6.6 4.3 15.7 8.3 27 11.9a107.7 107.7 0 0033 5.3c11 0 22-1.8 33-5.3 11.2-3.6 20.3-7.6 27-12l21-13.4c9.7-6.3 14.7-8.5 20-8.5 13.3 0 25.7 2.3 37 6.7a89 89 0 0128.9 18.2c7.6 7.3 14.4 16.1 20.2 26.3 5.5 9.8 10 20 13.3 30.3a305.5 305.5 0 0112.1 64.9c.7 9.8 1 20 1 30.2z" fill="#6aa9ff"/>
                </svg>
                People
            </a>
            <a href="#" class="status-action">
                <!-- Check In Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path d="M87.084 192c-.456-5.272-.688-10.6-.688-16C86.404 78.8 162.34 0 256.004 0s169.6 78.8 169.6 176c0 5.392-.232 10.728-.688 16h.688c0 96.184-169.6 320-169.6 320s-169.6-223.288-169.6-320h.68zm168.92 32c36.392 1.024 66.744-27.608 67.84-64-1.096-36.392-31.448-65.024-67.84-64-36.392-1.024-66.744 27.608-67.84 64 1.096 36.392 31.448 65.024 67.84 64z" fill="#e21b1b"/>
                </svg>
                Check in
            </a>
            <a href="#" class="status-action">
                <!-- Mood Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <circle cx="256" cy="256" r="256" fill="#ffca28"/>
                <g fill="#6d4c41">
                    <path d="M399.68 208.32c-8.832 0-16-7.168-16-16 0-17.632-14.336-32-32-32s-32 14.368-32 32c0 8.832-7.168 16-16 16s-16-7.168-16-16c0-35.296 28.704-64 64-64s64 28.704 64 64c0 8.864-7.168 16-16 16zM207.68 208.32c-8.832 0-16-7.168-16-16 0-17.632-14.368-32-32-32s-32 14.368-32 32c0 8.832-7.168 16-16 16s-16-7.168-16-16c0-35.296 28.704-64 64-64s64 28.704 64 64c0 8.864-7.168 16-16 16z"/>
                </g>
                <path d="M437.696 294.688c-3.04-4-7.744-6.368-12.736-6.368H86.4c-5.024 0-9.728 2.336-12.736 6.336-3.072 4.032-4.032 9.184-2.688 14.016C94.112 390.88 170.08 448.32 255.648 448.32s161.536-57.44 184.672-139.648c1.376-4.832.416-9.984-2.624-13.984z" fill="#fafafa"/>
                </svg>
                Mood
            </a>
            <button class="share-btn">Share</button>
            </div>
        </div>
    </form>
    
    
    