<?php

namespace App\Livewire\Pages;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Carbon;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\Mention\Generator\MentionGeneratorInterface;
use League\CommonMark\Extension\Mention\Mention;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Node\Inline\AbstractInline;

class Changelog extends Component
{

    protected $config = [];


    public function mount()
    {
        $this->config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'apply_id_to_heading' => false,
                'heading_class' => '',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => "",
                'aria_hidden' => true,
            ],
            'html_input' => 'strip',
            'mentions' => [
                // GitHub handler mention configuration.
                // Sample Input:  `@colinodell`
                // Sample Output: `<a href="https://www.github.com/colinodell">@colinodell</a>`
                'github_handle' => [
                    'prefix' => '@',
                    'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                    'generator' => 'https://github.com/%s',
                ],
                'github_issue' => [
                    'prefix'    => '#',
                    'pattern'   => '\d+',
                    // Alternatively, if your logic is simple, you can implement an inline anonymous class like this example.
                    'generator' => new class implements MentionGeneratorInterface
                    {
                        public function generateMention(Mention $mention): ?AbstractInline
                        {
                            $mention->setUrl(\sprintf('https://github.com/thephpleague/commonmark/issues/%d', $mention->getIdentifier()));

                            return $mention;
                        }
                    },
                ],

                'github_issue' => [
                    'prefix'    => '#',
                    'pattern'   => '\d+',
                    // Any type of callable, including anonymous closures, (with optional typehints) are also supported.
                    // This allows for better compatibility between different major versions of CommonMark.
                    // However, you sacrifice the ability to type-check which means automated development tools
                    // may not notice if your code is no longer compatible with new versions - you'll need to
                    // manually verify this yourself.
                    'generator' => function ($mention) {
                        // Immediately return if not passed the supported Mention object.
                        // This is an example of the types of manual checks you'll need to perform if not using type hints
                        if (!($mention instanceof Mention)) {
                            return null;
                        }

                        $mention->setUrl(\sprintf('https://github.com/thephpleague/commonmark/issues/%d', $mention->getIdentifier()));

                        return $mention;
                    },
                ],
            ]
        ];
    }



    #[Computed]
    public function releases()
    {
        $key = "releases";
        $seconds = 3600 * 6 * 24;
        return Cache::remember(
            $key,
            $seconds,
            function () {
                $request = Http::withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => ' Bearer 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',
                ])->get('https://api.github.com/repos/yanalshoubaki/loqui/releases');
                return $request->json();
            }
        );
    }

    public function render()
    {

        // Configure the Environment with all the CommonMark parsers/renderers
        $environment = new Environment($this->config);
        $environment->addExtension(new CommonMarkCoreExtension());

        // Add the Mention extension.
        $environment->addExtension(new MentionExtension());

        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TaskListExtension());
        $environment->addExtension(new DescriptionListExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());


        // Instantiate the converter engine and start converting some Markdown!
        $converter = new MarkdownConverter($environment);

        // dd($this->releases());
        return view('livewire.pages.changelog', [
            'releases' => $this->releases(),
            'converter' => $converter
        ])->extends('components.layouts.app');
    }
}
