import { useForm } from '@inertiajs/react';
import { FormEventHandler, useRef } from 'react';

import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogTitle, DialogTrigger } from '@/components/ui/dialog';

export function UserActions() {
    const passwordInput = useRef<HTMLInputElement>(null);
    const { data, setData, delete: destroy, put, processing, reset, errors, clearErrors } = useForm({ password: '' });

    const deleteUser: FormEventHandler = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current?.focus(),
            onFinish: () => reset(),
        });
    };

    const deactivateUser: FormEventHandler = (e) => {
        e.preventDefault();

        put(route('profile.deactivate'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current?.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        clearErrors();
        reset();
    };

    return (
        <div className="space-y-6">
            <div>
                <Dialog>
                    <DialogTrigger asChild>
                        <Button
                            variant="destructive"
                            className="w-full border-yellow-100 bg-yellow-50 text-yellow-600 dark:border-yellow-200/10 dark:bg-yellow-700/10"
                        >
                            Deactivate account
                        </Button>
                    </DialogTrigger>
                    <DialogContent>
                        <DialogTitle>Are you sure you want to deactivate your account?</DialogTitle>
                        <DialogDescription>
                            Once your account is deactivate, you will no longer be able to access your account. Please enter your password to confirm
                            you would like to deactivate your account.
                        </DialogDescription>
                        <form className="space-y-6" onSubmit={deactivateUser}>
                            <div className="grid gap-2">
                                <Label htmlFor="password" className="sr-only">
                                    Password
                                </Label>

                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    ref={passwordInput}
                                    value={data.password}
                                    onChange={(e) => setData('password', e.target.value)}
                                    placeholder="Password"
                                    autoComplete="current-password"
                                />

                                <InputError message={errors.password} />
                            </div>

                            <DialogFooter className="gap-2">
                                <DialogClose asChild>
                                    <Button variant="secondary" onClick={closeModal}>
                                        Cancel
                                    </Button>
                                </DialogClose>

                                <Button variant="destructive" disabled={processing} asChild>
                                    <button type="submit">Deactivate account</button>
                                </Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>
            <div>
                <div className="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                    <div className="relative space-y-0.5 text-red-600 dark:text-red-100">
                        <p className="font-medium">Warning</p>
                        <p className="text-sm">Please proceed with caution, this cannot be undone.</p>
                    </div>

                    <Dialog>
                        <DialogTrigger asChild>
                            <Button variant="destructive">Delete account</Button>
                        </DialogTrigger>
                        <DialogContent>
                            <DialogTitle>Are you sure you want to delete your account?</DialogTitle>
                            <DialogDescription>
                                Once your account is deleted, all of its resources and data will also be permanently deleted. Please enter your
                                password to confirm you would like to permanently delete your account.
                            </DialogDescription>
                            <form className="space-y-6" onSubmit={deleteUser}>
                                <div className="grid gap-2">
                                    <Label htmlFor="password" className="sr-only">
                                        Password
                                    </Label>

                                    <Input
                                        id="password"
                                        type="password"
                                        name="password"
                                        ref={passwordInput}
                                        value={data.password}
                                        onChange={(e) => setData('password', e.target.value)}
                                        placeholder="Password"
                                        autoComplete="current-password"
                                    />

                                    <InputError message={errors.password} />
                                </div>

                                <DialogFooter className="gap-2">
                                    <DialogClose asChild>
                                        <Button variant="secondary" onClick={closeModal}>
                                            Cancel
                                        </Button>
                                    </DialogClose>

                                    <Button variant="destructive" disabled={processing} asChild>
                                        <button type="submit">Delete account</button>
                                    </Button>
                                </DialogFooter>
                            </form>
                        </DialogContent>
                    </Dialog>
                </div>
            </div>
        </div>
    );
}
