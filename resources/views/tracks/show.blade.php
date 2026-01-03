@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* Container for the 12 boxes */
    .examples-grid-container {
        display: flex;
        flex-direction: column;
        gap: 35px;
        margin-bottom: 60px;
    }

    /* Large box design */
    .mega-example-card {
        background: #1a1a1a;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #333;
        width: 100%;
    }

    .card-header-main {
        padding: 20px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.03);
    }

    .card-header-main h3 { margin: 0; font-size: 1.5rem; font-weight: bold; }

    /* Formatting the three examples inside the box */
    .sub-examples-list {
        display: flex;
        flex-direction: column;
    }

    .single-example-row {
        display: flex;
        border-top: 1px solid #222;
        min-height: 100px;
    }

    .code-part {
        flex: 1;
        background: #000;
        padding: 20px;
        direction: ltr;
        text-align: left;
        display: flex;
        align-items: center;
        position: relative;
    }

    .info-part {
        width: 350px;
        padding: 20px;
        background: #1e1e1e;
        border-left: 1px solid #222;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: left;
    }

    .info-part h6 { color: #fff; margin-bottom: 5px; font-weight: bold; }
    .info-part p { color: #888; margin: 0; font-size: 0.9rem; }

    code { font-family: 'Consolas', monospace; color: #00ffaa; font-size: 1rem; }
    
    .copy-row-btn {
        position: absolute;
        top: 8px;
        left: 8px;
        background: #333;
        color: #ddd;
        border: none;
        padding: 3px 10px;
        border-radius: 5px;
        font-size: 10px;
        cursor: pointer;
    }

    .copy-row-btn:hover { background: #444; color: #fff; }
</style>
@endpush

<main class="main-content">
    @if($track->slug == 'html')
    <h1 class="text-center mb-5" style="color: #444;">HTML Examples on the ITLAB Platform</h1>

    <div class="examples-grid-container">
        @php
            $colors = ['#00ffaa', '#0f404eff', '#ff5252', '#ffeb3b', '#e040fb', '#ff9100', '#4db6ac', '#81c784', '#d4e157', '#ffd54f', '#ff8a65', '#a1887f'];
            
            $allCards = [
                ['t' => '1. Page Structure Basics', 'exs' => [
                    ['n' => 'Page Declaration', 'd' => 'Tells the browser this is an HTML5 file.', 'c' => '<!DOCTYPE html>'],
                    ['n' => 'Root Tag', 'd' => 'The main container for all page code.', 'c' => '<html> ... </html>'],
                    ['n' => 'Page Header', 'd' => 'Contains the title and metadata.', 'c' => '<head> ... </head>']
                ]],
                ['t' => '2. Headings and Main Text', 'exs' => [
                    ['n' => 'Largest Heading', 'd' => 'Used for the main topic title.', 'c' => '<h1>Main Heading</h1>'],
                    ['n' => 'Medium Heading', 'd' => 'Used for section titles.', 'c' => '<h3>Section Title</h3>'],
                    ['n' => 'Smallest Heading', 'd' => 'Used for side headings.', 'c' => '<h6>Side Heading</h6>']
                ]],
                ['t' => '3. Paragraphs and Content Formatting', 'exs' => [
                    ['n' => 'Text Paragraph', 'd' => 'For writing text and paragraphs.', 'c' => '<p>This is a paragraph</p>'],
                    ['n' => 'Bold Text', 'd' => 'To emphasize very important words.', 'c' => '<strong>Important Text</strong>'],
                    ['n' => 'Highlighted Text', 'd' => 'To highlight a specific text background.', 'c' => '<mark>Highlighted Text</mark>']
                ]],
                ['t' => '4. Interactive Links', 'exs' => [
                    ['n' => 'External Link', 'd' => 'Takes the user to another site.', 'c' => '<a href="https://google.com">Google</a>'],
                    ['n' => 'Open in New Window', 'd' => 'To keep your site open.', 'c' => '<a href="#" target="_blank">Link</a>'],
                    ['n' => 'Email Link', 'd' => 'For instant messaging.', 'c' => '<a href="mailto:a@it.com">Our Email</a>']
                ]],
                ['t' => '5. Images and Graphics', 'exs' => [
                    ['n' => 'Insert Image', 'd' => 'Display an image from a specific path.', 'c' => '<img src="pic.jpg" alt="Logo">'],
                    ['n' => 'Clickable Image', 'd' => 'Use the image as a link.', 'c' => '<a href="#"><img src="btn.png"></a>'],
                    ['n' => 'Image Dimensions', 'd' => 'Set width and height manually.', 'c' => '<img src="i.jpg" width="100" height="100">']
                ]],
                ['t' => '6. Organized Lists', 'exs' => [
                    ['n' => 'Bulleted List', 'd' => 'Display items without order.', 'c' => '<ul><li>Item</li></ul>'],
                    ['n' => 'Numbered List', 'd' => 'Display automatically numbered items.', 'c' => '<ol><li>First</li></ol>'],
                    ['n' => 'Nested List', 'd' => 'A list inside another list.', 'c' => '<ul><li>1<ul><li>2</li></ul></li></ul>']
                ]],
                ['t' => '7. Tables and Data', 'exs' => [
                    ['n' => 'Simple Table', 'd' => 'Display data in rows.', 'c' => '<table><tr><td>Data</td></tr></table>'],
                    ['n' => 'Table Caption', 'd' => 'Place a description above the table.', 'c' => '<caption>Sales Table</caption>'],
                    ['n' => 'Column Header', 'd' => 'Mark headings inside the table.', 'c' => '<th>Name</th>']
                ]],
                ['t' => '8. Basic Input Fields', 'exs' => [
                    ['n' => 'Text Field', 'd' => 'For entering name or text.', 'c' => '<input type="text" placeholder="Name">'],
                    ['n' => 'Password Field', 'd' => 'Hides characters when typing.', 'c' => '<input type="password">'],
                    ['n' => 'Email Field', 'd' => 'Validates email format.', 'c' => '<input type="email">']
                ]],
                ['t' => '9. Selection Tools', 'exs' => [
                    ['n' => 'Checkbox', 'd' => 'To select multiple options.', 'c' => '<input type="checkbox">'],
                    ['n' => 'Radio Button', 'd' => 'To select only one option.', 'c' => '<input type="radio" name="g">'],
                    ['n' => 'Dropdown List', 'd' => 'To select from a group of options.', 'c' => '<select><option>Option</option></select>']
                ]],
                ['t' => '10. Buttons and Interaction', 'exs' => [
                    ['n' => 'Submit Button', 'd' => 'To send form data.', 'c' => '<button type="submit">Submit</button>'],
                    ['n' => 'Reset Button', 'd' => 'To clear all fields.', 'c' => '<input type="reset" value="Clear">'],
                    ['n' => 'Custom Button', 'd' => 'To execute JavaScript code.', 'c' => '<button type="button">Click</button>']
                ]],
                ['t' => '11. Division Containers (CSS Preparation)', 'exs' => [
                    ['n' => 'Main Container', 'd' => 'To divide the page into boxes.', 'c' => '<div class="box">Content</div>'],
                    ['n' => 'Text Container', 'd' => 'To format part of the text.', 'c' => '<span>Colored Text</span>'],
                    ['n' => 'Navigation Bar', 'd' => 'Contains menu links.', 'c' => '<nav> Links </nav>']
                ]],
                ['t' => '12. Advanced Media', 'exs' => [
                    ['n' => 'Video Player', 'd' => 'Play MP4 videos.', 'c' => '<video controls src="v.mp4"></video>'],
                    ['n' => 'Audio Player', 'd' => 'Play MP3 files.', 'c' => '<audio controls src="a.mp3"></audio>'],
                    ['n' => 'External Embed', 'd' => 'Display another page inside your page.', 'c' => '<iframe src="page.html"></iframe>']
                ]]
            ];
        @endphp

        @foreach($allCards as $index => $card)
                <div class="mega-example-card shadow-lg" style="border-left: 15px solid {{ $colors[$index] }};">
            <div class="card-header-main">
                <h3 style="color: {{ $colors[$index] }};">{{ $card['t'] }}</h3>
                <span style="color: #666; font-size: 12px;">Educational Box #{{ $index + 1 }}</span>
            </div>
            <div class="sub-examples-list">
                @foreach($card['exs'] as $ex)
                <div class="single-example-row">
                    {{-- Code --}}
                    <div class="code-part">
                        <button class="copy-row-btn" onclick="copySnippet(this)">Copy</button>
                        <code>{{ $ex['c'] }}</code>
                    </div>
                    {{-- Description --}}
                    <div class="info-part">
                        <h6>{{ $ex['n'] }}</h6>
                        <p>{{ $ex['d'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    @endif
</main>



@push('scripts')
<script>
    function copySnippet(btn) {
        const code = btn.nextElementSibling.innerText;
        navigator.clipboard.writeText(code);
        btn.innerText = '✅';
        setTimeout(() => btn.innerText = 'Copy', 1500);
    }
</script>
@endpush
@endsection