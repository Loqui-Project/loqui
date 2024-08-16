@use(Illuminate\Support\Carbon, 'Carbon')
<div class="container">
    <section class="relative min-h-screen flex flex-col justify-center overflow-hidden antialiased">
        <div class="w-full max-w-6xl mx-auto px-4 md:px-6 py-4">

            <div class="flex flex-col justify-center divide-y divide-slate-200 [&>*]:py-16">
                <div class="w-full max-w-3xl mx-auto">
                    <div class="mb-10 prose dark:prose-headings:text-white dark:prose-p:text-white">
                        <h1>
                            Changelog
                        </h1>
                        <p>
                            Here you can find the latest changes to the project.
                        </p>
                    </div>
                    <div
                        class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:ml-[8.75rem] md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-300 before:to-transparent">
                        @forelse ($releases as $release)
                            <div class="relative">
                                <div class="md:flex items-center md:space-x-4 mb-3">
                                    <div class="flex items-center space-x-14 md:space-x-2 md:space-x-reverse">
                                        <div
                                            class="flex items-center justify-center w-4 h-4 absolute left-3 rounded-full bg-white shadow md:order-1">

                                        </div>
                                        <time
                                            class="text-sm font-medium dark:text-brand-main md:w-28">{{ Carbon::parse($release['created_at'])->format('Y-m-d H:i:s') }}</time>
                                    </div>
                                    <div class="dark:text-brand-main ml-14"><span
                                            class="dark:text-white font-bold">Version</span> {{ $release['tag_name'] }}
                                    </div>
                                </div>
                                <div
                                    class="prose dark:prose-headings:text-white dark:prose-a:text-brand-main dark:prose-strong:text-white dark:prose-p:text-white  ml-14 text-white z-50 p-10 shadow-surface-glass max-laptop:py-4   [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] shadow-sm rounded-md bg-white/30 dark:bg-brand-dark/30">
                                    {!! $converter->convert($release['body']) !!}
                                </div>
                            </div>
                        @empty
                            <div>
                                There is no releases
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
