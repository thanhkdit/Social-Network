
<div id="rise" class="rise">
    <i class="rise__btn-close fas fa-chevron-up"></i>
    <div class="calendar">
        <h3>Calendar</h3>
        <div class="calendar__header calendar-title">
            <h4>Title</h4>
            <p></p>
        </div>
        <div class="calendar__time calendar-title">
            <h4>Time</h4>
            <p></p>
        </div>
        <div class="calendar__content calendar-title">
            <h4>Content</h4>
            <p></p>
        </div>
    </div>
    <div class="add_calendar">
        <h3>Add Calendar</h3>
        <form id="form_add_calendar" action="/add-calendar" method="POST">
            @csrf
            <div class="form-group">
                <label class="col-3" for="">*Title</label>
                <input autocomplete="off" id="title_calendar" type="text" name="title" class="title_calendar form-control">
                <span class="alert-required">This field is required</span>
            </div>
            <div class="form-group">
                <label class="col-3" for="">*Time</label>
                <input autocomplete="off" type="datetime-local" name="time" class="time_calendar form-control">
                <span class="alert-required">This field is required</span>
            </div>
            <div class="form-group">
                <label class="col-3" for="">Content</label>
                <textarea cols="30" rows="4" name="content" class="content_calendar form-control"></textarea>
            </div>
            <input class="btn_submit btn btn-primary" type="submit" value="Add">
        </form>
    </div>
    <div class="delete_all_calendar">
        <h4>Are you sure to delete all calendar ?</h4>
        <form id="form_delete_all_calendar" action="#" method="POST">
            <div class="delete_all btn btn-outline-success">
                <i class="fas fa-check"></i>
            </div>
            <div class="cancel_delete_all btn btn-outline-secondary">
                <i class="fas fa-times"></i>
            </div>
        </form>
        <small class="alert alert-danger">Note: You can't restore your calendar</small>
    </div>
    <div class="create-post">
        <h4>Create Post</h4>
        <form action="/post/create" enctype='multipart/form-data' method="POST" class="form-create-post" id="form-create-post">
            @csrf
            <div class="create-post__top">
                <span class="avatar">
                    <img src="{{ auth()->user()->avatar }}" alt="avatar">
                </span>
                <div class="post-info">
                    <div class="post-info__poster">
                        <b>
                            {{ auth()->user()->name }}
                        </b>
                        <span>
                            <i class="i-feeling"></i>
                            <b class="b-feeling"></b>
                            <i class="i-with"></i>
                            <b class="b-with"></b>
                            <i class="i-at"></i>
                            <b class="b-at"></b>
                        </span>
                    </div>
                    <select name="type" class="post-info__audience" id="audience">
                        <option value="1">Public</option>
                        <option value="2">Friends</option>
                        <option value="3">Only me</option>
                    </select>
                </div>
            </div>
            <textarea name="content" class="post-content" id="post-content" rows="6" placeholder="What's on your mind?"></textarea>
            
            <div class="more-functions">
                <div class="functions-buttons">
                    <div class="functions-buttons__one functions-buttons__one-media">
                        <label for="post-media">
                            <i class="fas fa-photo-video"></i>
                        </label>
                        <input type="number" hidden name="MAX_SIZE_FILE" class="max_size_file" value='6'>
                        <input type="file" name="f_media[]" id="post-media" multiple hidden accept="image/*, video/*">
                    </div>
                    <div class="functions-buttons__one functions-buttons__one-action">
                        <span>
                            <i class="far fa-kiss-beam"></i>
                        </span>
                    </div>
                    <div class="functions-buttons__one functions-buttons__one-tag">
                        <span>
                            <i class="fas fa-user-friends"></i>
                        </span>
                    </div>
                    <div class="functions-buttons__one functions-buttons__one-feeling">
                        <span>
                            <i class="fas fa-heartbeat"></i>
                        </span>
                    </div>
                    <div class="functions-buttons__one functions-buttons__one-location">
                        <span>
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                    </div>
                </div>
                <div class="alert alert-danger custom-alert"></div>
                <div class="functions-content">
                    <div class="preview">
                        <div class="preview-top">
                            <h6>Preview</h6>
                            <div class="preview-top__buttons">
                                <div class="preview-top__buttons-close">
                                    <i class="fas fa-times"></i>
                                </div>
                            </div>
                        </div>
                        <div class="functions-content__image">
                            <div class="functions-content__image-one">
                                <img src="./images/status-1.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="functions-content__list">
                        <div class="functions-content__tag">
                            <div class="functions-content__tag-box">
                                <div class="tag-box__top">
                                    <i>With:</i>
                                    <i class="btn-close"></i>
                                </div>
                                <ul>
                                    @foreach($friends as $row)
                                    <li class="post-tag-item" user_id="{{ $row->id }}">
                                        <div class="avatar">
                                            <img src="{{ $row->avatar }}" alt="">
                                        </div>
                                        <div class="username">
                                            <p>{{ $row->name }}</p>
                                            <small>{{ $row->description }}</small>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="functions-content__tag-input">
                                <i>With:</i>
                                <input autocomplete="off" type="text" name="tag" class="tag-fake">
                                <input type="text" hidden name="tags" class="tag-real">
                            </div>
                        </div>
                        <div class="functions-content__feeling">
                            <div class="functions-content__feeling-box">
                                <div class="feeling-box__top">
                                    <i>Feeling:</i>
                                    <i class="btn-close"></i>
                                </div>
                                <input type="text" hidden name="feeling" id="input-post-feeling">
                                <ul>
                                    <li>😁 happy</li>
                                    <li>😇 blessed</li>
                                    <li>😘 loved</li>
                                    <li>😞 sad</li>
                                    <li>😊 lovely</li>
                                    <li>😚 thankful</li>
                                    <li>😃 excited</li>
                                    <li>😍 in love</li>
                                    <li>🤪 crazy</li>
                                    <li>🤗 grateful</li>
                                    <li>😊 blissful</li>
                                    <li>😁 fantastic</li>
                                    <li>😜 silly</li>
                                    <li>😆 wonderfull</li>
                                    <li>😎 cool</li>
                                    <li>😗 amused</li>
                                    <li>🤗 relaxed</li>
                                    <li>🧐 positive</li>
                                    <li>😜 chill</li>
                                    <li>😔 tired</li>
                                    <li>😶 alone</li>
                                    <li>🤗 proud</li>
                                    <li>🙂 OK</li>
                                    <li>😤 angry</li>
                                    <li>😷 sick</li>
                                    <li>🤓 confident</li>
                                    <li>😙 awesome</li>
                                    <li>🤣 fresh</li>
                                    <li>😆 glad</li>
                                    <li>🤑 lucky</li>
                                    <li>🙁 bored</li>
                                    <li>😴 sleepy</li>
                                    <li>😣 hungry</li>
                                    <li>🤕 pained</li>
                                    <li>😇 peaceful</li>
                                    <li>😝 cute</li>
                                    <li>😁 great</li>
                                    <li>😶 sorry</li>
                                    <li>😬 worried</li>
                                    <li>😫 bad</li>
                                    <li>😵 confused</li>
                                    <li>😢 missing</li>
                                    <li>😀 good</li>
                                    <li>😲 amazing</li>
                                    <li>😇 beautiful</li>
                                    <li>😭 broken</li>
                                    <li>🤠 safe</li>
                                    <li>😑 lazy</li>
                                    <li>😵 stupid</li>
                                    <li>😫 terrible</li>
                                    <li>😨 old</li>
                                    <li>😝 well</li>
                                    <li>🤗 alive</li>
                                    <li>🤕 hurt</li>
                                    <li>😊 kind</li>
                                    <li>😎 ready</li>
                                    <li>😁 nice</li>
                                    <li>🧐 important</li>
                                    <li>🤮 full</li>
                                    <li>😯 small</li>
                                    <li>🤗 warm</li>
                                    <li>🤧 busy</li>
                                    <li>😰 thirsty</li>
                                    <li>😬 scared</li>
                                    <li>😁 perfect</li>
                                    <li>😀 challenged</li>
                                    <li>🤓 smart</li>
                                    <li>🤑 rich</li>
                                    <li>😞 poor</li>
                                </ul>
                            </div>
                            <div class="functions-content__feeling-input">
                                <i>Feeling:</i>
                                <input autocomplete="off" type="text" name="feeling">
                            </div>
                        </div>
                        <div class="functions-content__location">
                            <div class="functions-content__location-input">
                                <i>At:</i>
                                <input autocomplete="off" type="text" name="location">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="create-post-button">
                <input autocomplete="off" type="submit" value="Create">
            </div>
        </form>
    </div>
</div>