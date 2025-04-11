import { MessagesClient } from '@/clients/messages.client';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Textarea } from '@/components/ui/textarea';
import { useMutation } from '@tanstack/react-query';
import { ImageIcon, Send, X } from 'lucide-react';
import { ChangeEvent, useRef, useState } from 'react';

type SendMessageProps = {
    userId: number;
};

export function SendMessage({ userId }: SendMessageProps) {
    const [messageText, setMessageText] = useState('');
    const [selectedImage, setSelectedImage] = useState<File | null>(null);
    const [imagePreview, setImagePreview] = useState<string | null>(null);
    const fileInputRef = useRef<HTMLInputElement>(null);

    const handleImageUpload = (e: ChangeEvent<HTMLInputElement>) => {
        if (e.target.files && e.target.files?.length > 0) {
            const file = e.target.files[0];

            setSelectedImage(file);

            // Create preview URL
            const reader = new FileReader();
            reader.onloadend = () => {
                if (reader.result === null) {
                    return;
                } else {
                    setImagePreview(reader.result as string);
                }
            };
            reader.readAsDataURL(file);
        }
    };

    const clearImage = () => {
        setSelectedImage(null);
        setImagePreview(null);
        if (fileInputRef.current) {
            fileInputRef.current.value = '';
        }
    };

    const { mutate } = useMutation({
        mutationKey: ['sendMessage', userId],
        mutationFn: () => {
            const formData = new FormData();
            formData.append('message', messageText);
            if (selectedImage) {
                formData.append('image', selectedImage);
            }
            formData.append('receiver_id', userId.toString());
            formData.append('isAnon', 'false');
            return MessagesClient.sendMessage(formData);
        },
        onSuccess: () => {
            setMessageText('');
            clearImage();
        },
    });

    const handleSubmit = () => {
        mutate();
    };

    return (
        <section id="message">
            <Card className="mb-8">
                <CardHeader className="pb-2">
                    <CardTitle className="text-lg">Share a message</CardTitle>
                    <CardDescription>Post an update to your followers</CardDescription>
                </CardHeader>
                <CardContent>
                    <Textarea
                        placeholder="What's on your mind?"
                        className="mb-3 min-h-[100px]"
                        value={messageText}
                        onChange={(e) => setMessageText(e.target.value)}
                    />

                    {/* Image preview area */}
                    {imagePreview && (
                        <div className="relative mb-3 inline-block">
                            <img src={imagePreview || '/placeholder.svg'} alt="Preview" className="max-h-[200px] rounded-md border" />
                            <Button variant="destructive" size="icon" className="absolute top-2 right-2 h-6 w-6 rounded-full" onClick={clearImage}>
                                <X className="h-4 w-4" />
                            </Button>
                        </div>
                    )}

                    <div className="flex items-center justify-between">
                        <div>
                            <input
                                type="file"
                                id="image-upload"
                                className="hidden"
                                accept="image/*"
                                onChange={handleImageUpload}
                                ref={fileInputRef}
                            />
                            <Button variant="outline" size="sm" onClick={() => fileInputRef.current?.click()}>
                                <ImageIcon className="mr-2 h-4 w-4" />
                                Add Image
                            </Button>
                        </div>
                        <Button onClick={handleSubmit} disabled={!messageText.trim() && !selectedImage}>
                            <Send className="mr-2 h-4 w-4" />
                            Post Message
                        </Button>
                    </div>
                </CardContent>
            </Card>
        </section>
    );
}
