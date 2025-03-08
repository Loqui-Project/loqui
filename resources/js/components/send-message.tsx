import {Card, CardContent, CardDescription, CardHeader, CardTitle} from "@/components/ui/card";
import {Textarea} from "@/components/ui/textarea";
import {Button} from "@/components/ui/button";
import {ImageIcon, Send, X} from "lucide-react";
import {useRef, useState} from "react";
import {useMutation} from "@tanstack/react-query";
import {MessagesClient} from "@/clients/messages.client";

type SendMessageProps = {
    userId: number;
}

export function SendMessage({userId}: SendMessageProps) {
    const [messageText, setMessageText] = useState("")
    const [selectedImage, setSelectedImage] = useState(null)
    const [imagePreview, setImagePreview] = useState(null)
    const fileInputRef = useRef(null)

    const handleImageUpload = (e) => {
        const file = e.target.files[0]
        if (file) {
            setSelectedImage(file)

            // Create preview URL
            const reader = new FileReader()
            reader.onloadend = () => {
                setImagePreview(reader.result)
            }
            reader.readAsDataURL(file)
        }
    }

    const clearImage = () => {
        setSelectedImage(null)
        setImagePreview(null)
        if (fileInputRef.current) {
            fileInputRef.current.value = ""
        }
    }



const {mutate} = useMutation({
    mutationKey: ['sendMessage', userId],
    mutationFn: () => {
        return MessagesClient.sendMessage(messageText, userId, false)
    }
})

    const handleSubmit = () => {
        // Here you would typically send the message and image to your backend
        console.log("Submitting message:", messageText)
        console.log("With image:", selectedImage)

        // Show success notification or update UI as needed
        mutate()
    }


    return (
        <Card className="mb-8">
            <CardHeader className="pb-2">
                <CardTitle className="text-lg">Share a message</CardTitle>
                <CardDescription>Post an update to your followers</CardDescription>
            </CardHeader>
            <CardContent>
                <Textarea
                    placeholder="What's on your mind?"
                    className="min-h-[100px] mb-3"
                    value={messageText}
                    onChange={(e) => setMessageText(e.target.value)}
                />

                {/* Image preview area */}
                {imagePreview && (
                    <div className="relative mb-3 inline-block">
                        <img
                            src={imagePreview || "/placeholder.svg"}
                            alt="Preview"
                            className="max-h-[200px] rounded-md border"
                        />
                        <Button
                            variant="destructive"
                            size="icon"
                            className="absolute top-2 right-2 h-6 w-6 rounded-full"
                            onClick={clearImage}
                        >
                            <X className="h-4 w-4" />
                        </Button>
                    </div>
                )}

                <div className="flex justify-between items-center">
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

    )
}
