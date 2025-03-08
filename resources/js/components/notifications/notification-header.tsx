import { Bell } from "lucide-react"
import { Button } from "@/components/ui/button"

export function NotificationsHeader() {
    return (
        <div className="flex items-center justify-between">
            <div className="flex items-center gap-2">
                <Bell className="h-5 w-5" />
                <h1 className="text-2xl font-bold tracking-tight">Notifications</h1>
            </div>

            <form>
                <Button variant="outline" size="sm">
                    Mark all as read
                </Button>
            </form>
        </div>
    )
}

